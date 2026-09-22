<?php

namespace App\Services\ContentAutomation;

use App\Models\ContentCategory;
use App\Models\Plant;
use App\Models\Post;
use Illuminate\Support\Str;

class ContentInternalLinkingService
{
    /**
     * Process HTML body and inject contextual internal links to published plants and articles.
     * Returns array with 'html' and 'linked_plant_ids'.
     */
    public function injectInternalLinks(string $htmlBody, int $maxLinks = 4): array
    {
        if (empty(trim($htmlBody))) {
            return ['html' => $htmlBody, 'linked_plant_ids' => []];
        }

        $linkedPlantIds = [];
        $linkCount = 0;

        // Fetch top published plants sorted by length descending so longer phrases match first
        $plants = Plant::published()
            ->select(['id', 'name', 'scientific_name', 'slug'])
            ->get()
            ->sortByDesc(fn($p) => strlen($p->name));

        foreach ($plants as $plant) {
            if ($linkCount >= $maxLinks) {
                break;
            }

            $name = $plant->name;
            $slug = $plant->slug;
            $url = url("/plants/{$slug}");

            // Match common plant name case-insensitively in HTML paragraphs
            $pattern = '/(?<=\b)(' . preg_quote($name, '/') . ')(?=\b)(?![^<]*>)(?![^<]*<\/a>)/i';

            if (preg_match($pattern, $htmlBody)) {
                $replacement = '<a href="' . $url . '" class="text-success fw-medium text-decoration-none hover-underline" title="' . e($name) . ' Care Guide">' . '$1' . '</a>';
                
                // Replace only the FIRST occurrence
                $count = 0;
                $htmlBody = preg_replace($pattern, $replacement, $htmlBody, 1, $count);

                if ($count > 0) {
                    $linkedPlantIds[] = $plant->id;
                    $linkCount++;
                }
            }
        }

        // Fetch top active content categories for internal category linking if slots remaining
        if ($linkCount < $maxLinks) {
            $categories = ContentCategory::active()
                ->select(['id', 'name', 'slug'])
                ->get()
                ->sortByDesc(fn($c) => strlen($c->name));

            foreach ($categories as $cat) {
                if ($linkCount >= $maxLinks) {
                    break;
                }

                $name = $cat->name;
                $slug = $cat->slug;
                $url = url("/articles/category/{$slug}");

                $pattern = '/(?<=\b)(' . preg_quote($name, '/') . ')(?=\b)(?![^<]*>)(?![^<]*<\/a>)/i';

                if (preg_match($pattern, $htmlBody)) {
                    $replacement = '<a href="' . $url . '" class="text-success fw-medium text-decoration-none hover-underline">' . '$1' . '</a>';
                    $count = 0;
                    $htmlBody = preg_replace($pattern, $replacement, $htmlBody, 1, $count);
                    if ($count > 0) {
                        $linkCount++;
                    }
                }
            }
        }

        return [
            'html' => $htmlBody,
            'linked_plant_ids' => array_unique($linkedPlantIds),
        ];
    }
}
