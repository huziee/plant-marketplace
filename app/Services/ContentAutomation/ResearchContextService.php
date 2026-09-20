<?php

namespace App\Services\ContentAutomation;

use App\Models\ContentCandidate;
use Illuminate\Support\Str;

class ResearchContextService
{
    /**
     * Build compact factual research context for a candidate and update its status.
     */
    public function buildContext(ContentCandidate $candidate): ContentCandidate
    {
        $candidate->load('researchSources');

        if ($candidate->content_type === 'news') {
            $context = $this->buildNewsContext($candidate);
        } else {
            $context = $this->buildArticleContext($candidate);
        }

        $candidate->update([
            'research_context' => $context,
            'status' => 'ready',
        ]);

        return $candidate;
    }

    /**
     * Build factual context for News candidate without storing third-party body copy.
     */
    protected function buildNewsContext(ContentCandidate $candidate): array
    {
        $sourceData = $candidate->source_data ?? [];
        $sources = $candidate->researchSources;

        $primarySource = $sources->first();

        $facts = [
            'event_title' => $candidate->suggested_title ?: ($primarySource?->source_title ?? 'Botanical News Update'),
            'topic_category' => $candidate->topic ?: 'botanical-news',
            'discovered_date' => $primarySource?->published_at?->toIso8601String() ?? now()->toIso8601String(),
            'source_domain' => $primarySource?->source_domain ?? 'News Network',
            'key_observations' => [
                "Discovered coverage regarding: " . ($candidate->suggested_title ?? 'Botanical Development'),
                "Category focus: " . ($candidate->topic ?? 'botanical-news'),
                "Factual context source domain: " . ($primarySource?->source_domain ?? 'Industry Source'),
            ],
        ];

        return [
            'type' => 'news',
            'topic' => $candidate->topic ?: 'botanical-news',
            'suggested_title' => $candidate->suggested_title,
            'facts' => $facts,
        ];
    }

    /**
     * Build factual context for Article candidate from OpenAlex research notes and Plantaric internal DB.
     */
    protected function buildArticleContext(ContentCandidate $candidate): array
    {
        $sourceData = $candidate->source_data ?? [];
        $sources = $candidate->researchSources;

        $academicNotes = [];
        foreach ($sources as $index => $source) {
            $meta = $source->metadata ?? [];
            $abstractSnippet = !empty($meta['abstract'])
                ? Str::limit($meta['abstract'], 400)
                : 'Scientific research exploring ' . $source->source_title;

            $academicNotes[] = [
                'ref_id' => $index + 1,
                'paper_title' => $source->source_title,
                'publication_year' => $source->published_at?->format('Y') ?? 'Recent',
                'concepts' => $meta['concepts'] ?? [],
                'summary_notes' => $abstractSnippet,
            ];
        }

        $internalData = $sourceData['internal_data'] ?? ['plants' => [], 'problems' => []];

        return [
            'type' => 'article',
            'topic' => $candidate->topic,
            'primary_keyword' => $candidate->primary_keyword,
            'academic_research_notes' => $academicNotes,
            'plantaric_internal_data' => $internalData,
        ];
    }
}
