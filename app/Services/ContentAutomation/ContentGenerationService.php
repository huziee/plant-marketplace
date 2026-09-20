<?php

namespace App\Services\ContentAutomation;

use App\Models\ContentCandidate;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentGenerationService
{
    protected string $apiKey;
    protected string $model;
    protected int $maxTokens;

    public function __construct(
        protected ContentQualityService $qualityService,
        protected SettingsService $settingsService
    ) {
        $this->apiKey = (string) config('services.openai.api_key', env('OPENAI_API_KEY'));
        $this->model = (string) $this->settingsService->get('automation.openai_model', config('services.openai.model', 'gpt-4o-mini'));
        $this->maxTokens = (int) config('services.openai.max_tokens', 2500);
    }

    /**
     * Generate original content for a ContentCandidate using OpenAI.
     */
    public function generate(ContentCandidate $candidate): array
    {
        if (empty($candidate->research_context)) {
            app(ResearchContextService::class)->buildContext($candidate);
            $candidate->refresh();
        }

        $candidate->update(['status' => 'generating']);

        $systemPrompt = $this->buildSystemPrompt($candidate->content_type);
        $userPrompt = $this->buildUserPrompt($candidate);

        try {
            if (empty($this->apiKey)) {
                throw new \InvalidArgumentException('OpenAI API key is missing in configuration.');
            }

            $response = Http::timeout(45)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'response_format' => ['type' => 'json_object'],
                    'temperature' => 0.7,
                    'max_tokens' => $this->maxTokens,
                ]);

            if ($response->failed()) {
                $errorMsg = 'OpenAI API Error HTTP ' . $response->status() . ': ' . $response->body();
                Log::error($errorMsg);
                $candidate->update([
                    'status' => 'failed',
                    'failure_reason' => $errorMsg,
                ]);
                return ['success' => false, 'error' => $errorMsg];
            }

            $resData = $response->json();
            $contentStr = $resData['choices'][0]['message']['content'] ?? '';

            $parsed = json_decode($contentStr, true);
            if (empty($parsed) || !is_array($parsed)) {
                $candidate->update([
                    'status' => 'failed',
                    'failure_reason' => 'Invalid or unparseable JSON response from OpenAI.',
                ]);
                return ['success' => false, 'error' => 'Invalid JSON from OpenAI.'];
            }

            // Quality and Originality validation
            $validation = $this->qualityService->validate($parsed, $candidate->content_type);
            if (!$validation['valid']) {
                $candidate->update([
                    'status' => 'failed',
                    'failure_reason' => $validation['reason'],
                ]);
                return ['success' => false, 'error' => $validation['reason']];
            }

            $candidate->update([
                'status' => 'generated',
                'generated_at' => now(),
            ]);

            return [
                'success' => true,
                'data' => $parsed,
            ];
        } catch (\Throwable $e) {
            Log::error('Content generation exception', ['error' => $e->getMessage()]);
            $candidate->update([
                'status' => 'failed',
                'failure_reason' => $e->getMessage(),
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * System prompt instructions for OpenAI.
     */
    protected function buildSystemPrompt(string $contentType): string
    {
        return <<<PROMPT
You are a senior botanical expert and editorial writer for "Plantaric", a premier online botanical encyclopedia, plant marketplace, and horticultural journal.

WRITING MANDATES:
1. Write a completely NEW, ORIGINAL, informative, and engaging publication in clean HTML format. Use semantic tags like <p>, <h2>>, <h3>, <ul>, <li>, <strong>, and <em>.
2. Rely strictly on the supplied factual research context for evidence and data.
3. ABSOLUTELY DO NOT copy sentences or closely paraphrase third-party structures.
4. ABSOLUTELY DO NOT mention external service names ("GDELT", "OpenAlex", "OpenAI"), third-party journalists, researcher author names, academic publishers, or external URLs in the public post text.
5. Content MUST be written from the authoritative voice of the "Plantaric Editorial Team".
6. Do NOT fabricate specific unsupported numbers, studies, or claims not present in the research context.
7. Return ONLY a valid JSON object matching the exact requested schema.
PROMPT;
    }

    /**
     * User prompt containing candidate research context.
     */
    protected function buildUserPrompt(ContentCandidate $candidate): string
    {
        $contextJson = json_encode($candidate->research_context, JSON_PRETTY_PRINT);
        $typeLabel = strtoupper($candidate->content_type);

        return <<<PROMPT
Generate a high-quality {$typeLabel} publication based on the following research context.

RESEARCH CONTEXT:
{$contextJson}

REQUIRED JSON OUTPUT FORMAT:
{
  "title": "Engaging, SEO-optimized title",
  "slug": "url-friendly-slug-phrase",
  "excerpt": "Compelling 2-3 sentence summary for post card previews",
  "body": "Full article body in HTML format with <h2>, <h3>, <p>, <ul>, <li>",
  "seo_title": "SEO title under 60 chars",
  "meta_description": "Meta description under 160 chars",
  "focus_keyword": "Primary keyword phrase",
  "category_slug": "Suggested category slug (e.g. plant-health, soil-and-growing, indoor-plants, horticulture, agriculture, botanical-news)",
  "tags": ["Tag 1", "Tag 2", "Tag 3"]
}
PROMPT;
    }
}
