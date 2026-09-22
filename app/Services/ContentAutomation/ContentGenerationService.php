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
        protected SettingsService $settingsService,
        protected ResearchReferenceFormatter $referenceFormatter,
        protected ContentInternalLinkingService $internalLinkingService
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

            // 1. Quality and Originality validation on pure AI generated payload
            $validation = $this->qualityService->validate($parsed, $candidate->content_type);
            if (!$validation['valid']) {
                $candidate->update([
                    'status' => 'failed',
                    'failure_reason' => $validation['reason'],
                ]);
                return ['success' => false, 'error' => $validation['reason']];
            }

            // 2. Post-processing: Inject internal links to Plantaric Encyclopedia & Categories
            $linkingResult = $this->internalLinkingService->injectInternalLinks($parsed['body'] ?? '');
            $parsed['body'] = $linkingResult['html'];
            $parsed['linked_plant_ids'] = $linkingResult['linked_plant_ids'];

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
You are a senior botanical writer and editor for "Plantaric", an online botanical encyclopedia, plant marketplace, and gardening journal.

TONE & VOICE MANDATES:
1. WRITING STYLE: Practical, engaging, informative, and authoritative—write like a master gardener sharing real-world guidance with a plant enthusiast.
2. NATURAL FLOW: Vary sentence lengths dynamically. Blend concise points with clear explanations. Use natural, conversational transitions.
3. PROBLEM-SOLUTION HOOK: Start directly with a relatable real-world garden challenge, specific diagnostic observation, or practical botanical insight. DO NOT start with generic fluff (e.g. "Plants have been important throughout history...").
4. PRACTICAL VALUE: Provide concrete gardening instructions, step-by-step diagnostic checklists, light/moisture test methods, and environmental ranges (Temperature, Humidity, Soil pH) where relevant.
5. BOOTSTRAP 5 HTML STYLING: Format body in semantic HTML (<p>, <h2>, <h3>, <ul>, <li>, <strong>, <em>). For callouts and pro-tips, use Bootstrap 5 markup:
   <div class="bg-light p-4 rounded-3 border-start border-4 border-success my-4"><strong>Pro Tip:</strong> ...</div>
   DO NOT use Tailwind CSS classes (such as bg-emerald-50 or rounded-r).
6. ABSOLUTE FORBIDDEN BUZZWORDS (DO NOT USE):
   - "delve", "tapestry", "testament", "nestled", "beacon", "game-changer", "paradigm shift"
   - "in conclusion", "it's essential to remember", "in today's fast-paced world", "realm of"
   - "furthermore", "moreover", "unlock the secrets", "dive deep into"
7. NO AI LEAKAGE: Never reference system prompts, OpenAI, GDELT, OpenAlex, or external algorithms. Do not claim certified personal titles like "Certified Master Horticulturist" in prose.
8. RETURN ONLY a valid JSON object matching the requested output schema.
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
Generate a practical, human-toned, highly useful {$typeLabel} publication based on the provided research context.

RESEARCH CONTEXT:
{$contextJson}

REQUIRED JSON OUTPUT FORMAT:
{
  "title": "Engaging, action-oriented title highlighting practical value",
  "slug": "url-friendly-slug-phrase",
  "excerpt": "Relatable 2-3 sentence summary hooking the reader with practical problem-solving value",
  "body": "Full article body in clean semantic HTML with <h2>, <h3>, <p>, <ul>, <li>, and Bootstrap 5 callout boxes (<div class=\"bg-light p-4 rounded-3 border-start border-4 border-success my-4\"><strong>Pro Tip:</strong> ...</div>)",
  "seo_title": "SEO title under 60 chars",
  "meta_description": "Meta description under 160 chars highlighting direct practical value",
  "focus_keyword": "Primary keyword phrase",
  "category_slug": "Suggested category slug (e.g. plant-health, soil-and-growing, indoor-plants, horticulture, agriculture, botanical-news)",
  "tags": ["Tag 1", "Tag 2", "Tag 3"]
}
PROMPT;
    }
}
