<?php

namespace App\Services\ContentAutomation;

use App\Models\ContentCandidate;
use App\Models\ContentResearchSource;
use App\Models\ContentTopic;
use App\Models\Plant;
use App\Models\PlantProblem;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ArticleDiscoveryService
{
    public function __construct(
        protected OpenAlexService $openAlexService,
        protected CandidateFingerprintService $fingerprintService,
        protected SettingsService $settingsService
    ) {}

    /**
     * Discover article research candidates.
     */
    public function discover(?int $maxToCreate = null): int
    {
        $limit = $maxToCreate ?? (int) $this->settingsService->get('automation.articles_per_day', 1);

        // Fetch active topics ordered by priority desc and last_used_at asc
        $topics = ContentTopic::where('content_type', 'article')
            ->where('active', true)
            ->orderBy('priority', 'desc')
            ->orderBy('last_used_at', 'asc')
            ->get();

        if ($topics->isEmpty()) {
            return 0;
        }

        $createdCount = 0;

        foreach ($topics as $topicItem) {
            if ($createdCount >= $limit) {
                break;
            }

            $fingerprint = $this->fingerprintService->forArticle(
                'openalex',
                $topicItem->topic,
                $topicItem->primary_keyword
            );

            if (ContentCandidate::where('fingerprint', $fingerprint)->exists()) {
                continue;
            }

            // Search OpenAlex
            $works = $this->openAlexService->searchWorks($topicItem->search_query, 15);
            if (empty($works)) {
                continue;
            }

            // Filter top 3-5 works with abstracts
            $selectedWorks = array_values(array_filter($works, fn ($w) => !empty($w['abstract'])));
            if (count($selectedWorks) < 2) {
                // Fallback to works without abstract if less than 2
                $selectedWorks = array_slice($works, 0, 4);
            } else {
                $selectedWorks = array_slice($selectedWorks, 0, 4);
            }

            if (empty($selectedWorks)) {
                continue;
            }

            // Search internal database for related plants or plant problems
            $internalData = $this->fetchInternalPlantaricData($topicItem->topic, $topicItem->primary_keyword);

            // Create ContentCandidate
            $candidate = ContentCandidate::create([
                'content_type' => 'article',
                'source_type' => !empty($internalData['plants']) || !empty($internalData['problems']) ? 'mixed' : 'openalex',
                'topic' => $topicItem->topic,
                'suggested_title' => "Guide to {$topicItem->topic}",
                'primary_keyword' => $topicItem->primary_keyword,
                'fingerprint' => $fingerprint,
                'source_data' => [
                    'topic_id' => $topicItem->id,
                    'works' => $selectedWorks,
                    'internal_data' => $internalData,
                ],
                'status' => 'discovered',
            ]);

            // Save private source records
            foreach ($selectedWorks as $work) {
                ContentResearchSource::create([
                    'content_candidate_id' => $candidate->id,
                    'provider' => 'openalex',
                    'source_type' => 'academic_paper',
                    'source_title' => $work['title'],
                    'source_url' => $work['landing_page_url'] ?: ($work['doi'] ?: ''),
                    'source_domain' => parse_url($work['landing_page_url'] ?: '', PHP_URL_HOST),
                    'external_id' => $work['id'],
                    'doi' => $work['doi'],
                    'published_at' => $work['publication_date'] ? \Illuminate\Support\Carbon::parse($work['publication_date']) : null,
                    'metadata' => [
                        'authors' => $work['authors'] ?? [],
                        'publisher' => $work['publisher'] ?? '',
                        'concepts' => $work['concepts'] ?? [],
                        'abstract' => $work['abstract'] ?? null,
                    ],
                    'is_public' => false,
                ]);
            }

            // Update topic last_used_at
            $topicItem->update(['last_used_at' => now()]);

            $createdCount++;
        }

        return $createdCount;
    }

    /**
     * Search internal Plantaric DB for matching plants or problems based on keywords.
     */
    protected function fetchInternalPlantaricData(string $topic, ?string $keyword): array
    {
        $internal = [
            'plants' => [],
            'problems' => [],
        ];

        $terms = array_filter(explode(' ', strtolower("{$topic} {$keyword}")));

        foreach ($terms as $term) {
            if (strlen($term) < 4) {
                continue;
            }

            $plants = Plant::with('care')
                ->where('name', 'like', "%{$term}%")
                ->orWhere('scientific_name', 'like', "%{$term}%")
                ->take(3)
                ->get();

            foreach ($plants as $p) {
                $internal['plants'][$p->id] = [
                    'id' => $p->id,
                    'name' => $p->name,
                    'scientific_name' => $p->scientific_name,
                    'watering' => $p->care?->watering_description,
                    'sunlight' => $p->care?->sunlight_description,
                    'soil' => $p->care?->soil_type,
                ];
            }

            $problems = PlantProblem::with(['symptoms', 'causes', 'treatments', 'preventions'])
                ->where('name', 'like', "%{$term}%")
                ->take(3)
                ->get();

            foreach ($problems as $prob) {
                $internal['problems'][$prob->id] = [
                    'id' => $prob->id,
                    'name' => $prob->name,
                    'symptoms' => $prob->symptoms->pluck('description')->toArray(),
                    'causes' => $prob->causes->pluck('description')->toArray(),
                    'treatments' => $prob->treatments->pluck('description')->toArray(),
                    'preventions' => $prob->preventions->pluck('description')->toArray(),
                ];
            }
        }

        $internal['plants'] = array_values($internal['plants']);
        $internal['problems'] = array_values($internal['problems']);

        return $internal;
    }
}
