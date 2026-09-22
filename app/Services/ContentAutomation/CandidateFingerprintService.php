<?php

namespace App\Services\ContentAutomation;

use Illuminate\Support\Str;

class CandidateFingerprintService
{
    /**
     * Generate deterministic fingerprint for news articles based on provider and normalized URL.
     */
    public function forNews(string $provider, string $url): string
    {
        $normalizedUrl = $this->normalizeUrl($url);
        return hash('sha256', "news|{$provider}|{$normalizedUrl}");
    }

    /**
     * Generate deterministic fingerprint for academic articles based on topic & keyword.
     */
    public function forArticle(string $sourceType, string $topic, ?string $keyword = null): string
    {
        $topicSlug = Str::slug($topic);
        $keywordSlug = $keyword ? Str::slug($keyword) : '';
        return hash('sha256', "article|{$sourceType}|{$topicSlug}|{$keywordSlug}");
    }

    /**
     * Normalize URL by stripping tracking parameters (utm_*, ref, etc.).
     */
    public function normalizeUrl(string $url): string
    {
        $parsed = parse_url($url);
        if (!$parsed || empty($parsed['host'])) {
            return strtolower(trim($url));
        }

        $scheme = strtolower($parsed['scheme'] ?? 'https');
        $host = strtolower($parsed['host']);
        $path = $parsed['path'] ?? '/';

        // Strip common tracking parameters from query
        $queryParams = [];
        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $queryParams);
            $trackingParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'ref', 'fbclid', 'gclid'];
            foreach ($trackingParams as $tp) {
                unset($queryParams[$tp]);
            }
        }

        ksort($queryParams);
        $queryString = http_build_query($queryParams);

        return $scheme . '://' . $host . rtrim($path, '/') . ($queryString ? '?' . $queryString : '');
    }

    /**
     * Check if a proposed candidate title or topic is a duplicate of an existing published post.
     */
    public function isDuplicateTopic(string $title): bool
    {
        $targetSlug = Str::slug($title);
        if (empty($targetSlug)) {
            return false;
        }

        // Exact slug check
        $existsExact = \App\Models\Post::where('slug', $targetSlug)->exists();
        if ($existsExact) {
            return true;
        }

        // Similar title check against last 100 posts
        $recentPosts = \App\Models\Post::select('title', 'slug')
            ->latest()
            ->take(100)
            ->get();

        foreach ($recentPosts as $post) {
            similar_text(strtolower($title), strtolower($post->title), $percent);
            if ($percent >= 80) {
                return true;
            }
        }

        return false;
    }
}
