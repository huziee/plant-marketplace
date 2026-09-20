<?php

namespace App\Services\ContentAutomation;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GdeltService
{
    protected string $baseUrl;
    protected int $maxRecords;
    protected string $timespan;

    public function __construct()
    {
        $this->baseUrl = config('services.gdelt.url', 'https://api.gdeltproject.org/api/v2/doc/doc');
        $this->maxRecords = (int) config('services.gdelt.max_records', 50);
        $this->timespan = config('services.gdelt.timespan', '24h');
    }

    /**
     * Search GDELT v2 Doc API for news records.
     */
    public function fetchNews(?string $query = null): array
    {
        $searchQuery = $query ?: $this->getDefaultQuery();

        try {
            $response = Http::timeout(12)
                ->get($this->baseUrl, [
                    'query' => $searchQuery,
                    'mode' => 'artlist',
                    'format' => 'json',
                    'maxrecords' => $this->maxRecords,
                    'timespan' => $this->timespan,
                    'sort' => 'datedesc',
                ]);

            $data = $response->json();

            // Fallback to 7d timespan if 24h yields empty results
            if (empty($data['articles'])) {
                $response = Http::timeout(12)
                    ->get($this->baseUrl, [
                        'query' => $searchQuery,
                        'mode' => 'artlist',
                        'format' => 'json',
                        'maxrecords' => $this->maxRecords,
                        'timespan' => '7d',
                        'sort' => 'datedesc',
                    ]);
                $data = $response->json();
            }

            if (empty($data['articles']) || !is_array($data['articles'])) {
                return [];
            }

            $normalized = [];
            foreach ($data['articles'] as $item) {
                if (empty($item['url']) || empty($item['title'])) {
                    continue;
                }

                $normalized[] = [
                    'url' => $item['url'],
                    'title' => trim(html_entity_decode($item['title'])),
                    'domain' => $item['domain'] ?? parse_url($item['url'], PHP_URL_HOST) ?? '',
                    'language' => $item['language'] ?? 'English',
                    'sourcecountry' => $item['sourcecountry'] ?? '',
                    'socialimage' => $item['socialimage'] ?? null,
                    'seendate' => $item['seendate'] ?? null,
                ];
            }

            return $normalized;
        } catch (\Throwable $e) {
            Log::error('GDELT API Exception', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Default combined botanical search query for GDELT.
     */
    public function getDefaultQuery(): string
    {
        return 'plant OR agriculture OR horticulture';
    }
}
