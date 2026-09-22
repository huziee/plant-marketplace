<?php

namespace App\Services\ContentAutomation;

use Illuminate\Support\Str;

class ContentQualityService
{
    /**
     * Validate quality and originality of generated content payload.
     */
    public function validate(array $payload, string $contentType = 'article'): array
    {
        $title = trim($payload['title'] ?? '');
        $body = trim($payload['body'] ?? '');
        $excerpt = trim($payload['excerpt'] ?? '');

        if (empty($title)) {
            return ['valid' => false, 'reason' => 'Generated title is empty.'];
        }

        if (empty($body)) {
            return ['valid' => false, 'reason' => 'Generated body content is empty.'];
        }

        $minChars = ($contentType === 'news') ? 350 : 600;
        if (mb_strlen(strip_tags($body)) < $minChars) {
            return ['valid' => false, 'reason' => "Generated body length (" . mb_strlen(strip_tags($body)) . " chars) is below minimum threshold ({$minChars} chars)."];
        }

        // Check for AI prompt leakage or meta references & robotic buzzwords
        $aiForbiddenPhrases = [
            'as an ai',
            'i am an ai',
            'language model',
            'as provided in the source',
            'in the provided prompt',
            'here is your article',
            'here is the news',
            'system prompt',
            'openai model',
            'openai chatgpt',
            'openalex database',
            'gdelt feed',
            'delve into',
            'tapestry of',
            'testament to',
            'in conclusion',
            'game-changer',
            'nestled in',
            'realm of',
            'in today\'s fast-paced',
            'unlock the secrets',
        ];

        $lowerBody = strtolower($body);
        $lowerTitle = strtolower($title);

        foreach ($aiForbiddenPhrases as $phrase) {
            if (str_contains($lowerBody, $phrase) || str_contains($lowerTitle, $phrase)) {
                return ['valid' => false, 'reason' => "Forbidden phrase or AI leakage detected: '{$phrase}'."];
            }
        }

        // Check for markdown JSON fence artifacts in body
        if (str_contains($body, '```json') || str_contains($body, '```')) {
            return ['valid' => false, 'reason' => 'Code fence or JSON artifacts present in generated body.'];
        }

        // Check for raw unlinked URLs embedded in body text (ignore href="..." attributes)
        $cleanBodyForUrlCheck = preg_replace('/href=[\'"][^\'"]+[\'"]/', '', $body);
        if (preg_match('/https?:\/\/[^\s"\'>]+/', $cleanBodyForUrlCheck)) {
            return ['valid' => false, 'reason' => 'Raw unlinked third-party URLs detected in generated body.'];
        }

        return ['valid' => true, 'reason' => null];
    }
}
