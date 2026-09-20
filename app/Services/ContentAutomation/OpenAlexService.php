<?php

namespace App\Services\ContentAutomation;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAlexService
{
    protected string $baseUrl;
    protected ?string $apiKey;
    protected int $perPage;

    public function __construct()
    {
        $this->baseUrl = config('services.openalex.url', 'https://api.openalex.org');
        $this->apiKey = config('services.openalex.api_key');
        $this->perPage = (int) config('services.openalex.per_page', 20);
    }

    /**
     * Search OpenAlex /works endpoint for research publications on a topic query.
     */
    public function searchWorks(string $query, int $limit = 10): array
    {
        try {
            $params = [
                'search' => $query,
                'per_page' => min($limit, $this->perPage),
                'sort' => 'publication_date:desc',
            ];

            if (!empty($this->apiKey)) {
                $params['api_key'] = $this->apiKey;
            }

            $response = Http::timeout(15)
                ->withHeaders([
                    'User-Agent' => 'PlantaricBot/1.0 (mailto:editorial@plantora.com)',
                ])
                ->get(rtrim($this->baseUrl, '/') . '/works', $params);

            if ($response->failed()) {
                Log::warning('OpenAlex API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [];
            }

            $data = $response->json();
            if (empty($data['results']) || !is_array($data['results'])) {
                return [];
            }

            $works = [];
            foreach ($data['results'] as $item) {
                if (empty($item['title'])) {
                    continue;
                }

                $abstract = $this->reconstructAbstract($item['abstract_inverted_index'] ?? null);

                $authors = [];
                if (!empty($item['authorships']) && is_array($item['authorships'])) {
                    foreach (array_slice($item['authorships'], 0, 5) as $auth) {
                        if (!empty($auth['author']['display_name'])) {
                            $authors[] = $auth['author']['display_name'];
                        }
                    }
                }

                $concepts = [];
                if (!empty($item['concepts']) && is_array($item['concepts'])) {
                    foreach (array_slice($item['concepts'], 0, 5) as $c) {
                        if (!empty($c['display_name'])) {
                            $concepts[] = $c['display_name'];
                        }
                    }
                }

                $works[] = [
                    'id' => $item['id'] ?? null,
                    'doi' => $item['doi'] ?? null,
                    'title' => trim($item['title']),
                    'publication_year' => $item['publication_year'] ?? null,
                    'publication_date' => $item['publication_date'] ?? null,
                    'landing_page_url' => $item['landing_page_url'] ?? $item['doi'] ?? $item['id'] ?? '',
                    'abstract' => $abstract,
                    'authors' => $authors,
                    'publisher' => $item['primary_location']['source']['display_name'] ?? null,
                    'concepts' => $concepts,
                    'open_access' => $item['open_access']['is_oa'] ?? false,
                ];
            }

            return $works;
        } catch (\Throwable $e) {
            Log::error('OpenAlex API Exception', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Reconstruct readable text abstract from OpenAlex abstract_inverted_index.
     */
    public function reconstructAbstract(?array $invertedIndex): ?string
    {
        if (empty($invertedIndex) || !is_array($invertedIndex)) {
            return null;
        }

        $wordMap = [];
        foreach ($invertedIndex as $word => $positions) {
            if (!is_array($positions)) {
                continue;
            }
            foreach ($positions as $pos) {
                if (is_int($pos) || is_numeric($pos)) {
                    $wordMap[(int) $pos] = $word;
                }
            }
        }

        if (empty($wordMap)) {
            return null;
        }

        ksort($wordMap);
        return trim(implode(' ', $wordMap));
    }
}
