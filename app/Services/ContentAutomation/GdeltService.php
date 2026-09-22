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
     * Search GDELT v2 Doc API for news records with fallback to Google News RSS.
     */
    public function fetchNews(?string $query = null): array
    {
        $searchQuery = $query ?: $this->getDefaultQuery();

        try {
            $response = Http::timeout(12)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PlantaricBot/1.0',
                ])
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
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PlantaricBot/1.0',
                    ])
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

            if (!empty($data['articles']) && is_array($data['articles'])) {
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
                if (!empty($normalized)) {
                    return $normalized;
                }
            }
        } catch (\Throwable $e) {
            Log::error('GDELT API Exception', ['error' => $e->getMessage()]);
        }

        // Reliable fallback to Google News RSS feed if GDELT rate-limits or returns empty
        return $this->fetchGoogleNewsRss();
    }

    /**
     * Fallback botanical news fetcher via Google News RSS feed.
     */
    protected function fetchGoogleNewsRss(): array
    {
        try {
            $rssUrl = 'https://news.google.com/rss/search?q=botany+OR+gardening+OR+houseplants+OR+horticulture&hl=en-US&gl=US&ceid=US:en';
            $response = Http::timeout(12)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PlantaricBot/1.0',
                ])
                ->get($rssUrl);

            if ($response->failed()) {
                return [];
            }

            $xml = @simplexml_load_string($response->body());
            if (!$xml || !isset($xml->channel->item)) {
                return [];
            }

            $articles = [];
            foreach ($xml->channel->item as $item) {
                $title = (string) $item->title;
                $link = (string) $item->link;
                $pubDate = (string) $item->pubDate;

                if (empty($title) || empty($link)) {
                    continue;
                }

                // Strip trailing source name from Google News title (e.g. "Title - Source")
                $cleanTitle = preg_replace('/\s+-\s+[^-]+$/', '', $title);

                $articles[] = [
                    'url' => $link,
                    'title' => trim(html_entity_decode($cleanTitle)),
                    'domain' => parse_url($link, PHP_URL_HOST) ?? 'news.google.com',
                    'language' => 'English',
                    'sourcecountry' => 'US',
                    'socialimage' => null,
                    'seendate' => !empty($pubDate) ? date('Ymd\THis\Z', strtotime($pubDate)) : null,
                ];
            }

            return $articles;
        } catch (\Throwable $e) {
            Log::error('Google News RSS Exception', ['error' => $e->getMessage()]);
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
