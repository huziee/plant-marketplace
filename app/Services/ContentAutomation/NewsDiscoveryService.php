<?php

namespace App\Services\ContentAutomation;

use App\Models\ContentCandidate;
use App\Models\ContentResearchSource;
use App\Services\SettingsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsDiscoveryService
{
    public function __construct(
        protected GdeltService $gdeltService,
        protected CandidateFingerprintService $fingerprintService,
        protected SettingsService $settingsService
    ) {}

    /**
     * Discover news candidates from GDELT.
     */
    public function discover(?int $maxToCreate = null): int
    {
        $articles = $this->gdeltService->fetchNews();
        if (empty($articles)) {
            return 0;
        }

        $limit = $maxToCreate ?? (int) $this->settingsService->get('automation.news_per_day', 1);
        $createdCount = 0;

        foreach ($articles as $article) {
            if ($createdCount >= $limit) {
                break;
            }

            $url = $article['url'];
            $title = $article['title'];
            $fingerprint = $this->fingerprintService->forNews('gdelt', $url);

            // Check duplicate candidate fingerprint
            if (ContentCandidate::where('fingerprint', $fingerprint)->exists()) {
                continue;
            }

            $topicCategory = $this->classifyTopic($title);

            // Create ContentCandidate
            $candidate = ContentCandidate::create([
                'content_type' => 'news',
                'source_type' => 'gdelt',
                'topic' => $topicCategory,
                'suggested_title' => $title,
                'fingerprint' => $fingerprint,
                'source_data' => $article,
                'status' => 'discovered',
            ]);

            // Create private ContentResearchSource
            $seenDate = !empty($article['seendate']) ? $this->parseGdeltDate($article['seendate']) : now();
            ContentResearchSource::create([
                'content_candidate_id' => $candidate->id,
                'provider' => 'gdelt',
                'source_type' => 'news_article',
                'source_title' => $title,
                'source_url' => $url,
                'source_domain' => $article['domain'] ?? parse_url($url, PHP_URL_HOST),
                'published_at' => $seenDate,
                'metadata' => [
                    'language' => $article['language'] ?? 'English',
                    'sourcecountry' => $article['sourcecountry'] ?? '',
                    'socialimage' => $article['socialimage'] ?? null,
                ],
                'is_public' => false,
            ]);

            $createdCount++;
        }

        return $createdCount;
    }

    /**
     * Deterministic news topic classification rule engine.
     */
    public function classifyTopic(string $title): string
    {
        $lower = strtolower($title);

        if (Str::contains($lower, ['disease', 'pathogen', 'fungal', 'infection', 'rot', 'pest', 'blight', 'virus'])) {
            return 'plant-disease';
        }
        if (Str::contains($lower, ['new species', 'species discovered', 'discovered plant', 'new plant'])) {
            return 'new-species';
        }
        if (Str::contains($lower, ['houseplant', 'indoor plant', 'succulent', 'monster', 'foliage'])) {
            return 'houseplants';
        }
        if (Str::contains($lower, ['soil', 'compost', 'microbiome', 'dirt', 'fertilizer'])) {
            return 'soil';
        }
        if (Str::contains($lower, ['conservation', 'biodiversity', 'endangered', 'forest', 'extinction'])) {
            return 'conservation';
        }
        if (Str::contains($lower, ['crop', 'agriculture', 'farming', 'harvest', 'yield'])) {
            return 'agriculture';
        }
        if (Str::contains($lower, ['horticulture', 'nursery', 'greenhouse', 'garden', 'landscaping'])) {
            return 'horticulture';
        }
        if (Str::contains($lower, ['research', 'scientist', 'study', 'university', 'discovery', 'gene'])) {
            return 'botanical-research';
        }

        return 'botanical-news';
    }

    /**
     * Parse GDELT seendate format (YYYYMMDDTHHMMSSZ).
     */
    protected function parseGdeltDate(string $seendate): Carbon
    {
        try {
            return Carbon::createFromFormat('Ymd\THis\Z', $seendate);
        } catch (\Throwable $e) {
            return now();
        }
    }
}
