<?php

namespace App\Services\ContentAutomation;

use App\Models\ContentCandidate;
use App\Models\Post;
use App\Models\PostSource;
use Illuminate\Support\Str;

class ResearchReferenceFormatter
{
    /**
     * Generate Bootstrap 5 HTML for verified research references section.
     */
    public function formatHtmlReferences(ContentCandidate $candidate): string
    {
        return '';
    }

    /**
     * Sync research sources into PostSource records for internal admin auditing.
     */
    public function syncPostSources(ContentCandidate $candidate, Post $post): void
    {
        $sources = $candidate->researchSources;

        foreach ($sources as $index => $source) {
            PostSource::firstOrCreate(
                [
                    'post_id' => $post->id,
                    'title' => $source->source_title,
                ],
                [
                    'url' => $source->source_url,
                    'publisher' => $source->source_domain ?: 'Research Archive',
                    'published_at' => $source->published_at,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
