<?php

namespace App\Services;

use App\Enums\PostType;
use App\Models\ContentCategory;
use App\Models\Page;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use App\Models\Post;

class SitemapService
{
    /**
     * Generate main sitemap index XML.
     */
    public function generateIndex(): string
    {
        $sitemaps = [
            url('/sitemaps/pages.xml'),
            url('/sitemaps/plants.xml'),
            url('/sitemaps/plant-categories.xml'),
            url('/sitemaps/plant-problems.xml'),
            url('/sitemaps/articles.xml'),
            url('/sitemaps/guides.xml'),
            url('/sitemaps/news.xml'),
            url('/sitemaps/content-categories.xml'),
            url('/sitemaps/products.xml'),
            url('/sitemaps/product-categories.xml'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($sitemaps as $loc) {
            $xml .= '<sitemap>';
            $xml .= '<loc>' . htmlspecialchars($loc) . '</loc>';
            $xml .= '<lastmod>' . now()->toIso8601String() . '</lastmod>';
            $xml .= '</sitemap>';
        }

        $xml .= '</sitemapindex>';

        return $xml;
    }

    /**
     * Generate static and CMS pages sitemap XML.
     */
    public function generatePages(): string
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/plants'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/plant-problems'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/articles'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/guides'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/news'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/shop'), 'priority' => '0.8', 'changefreq' => 'daily', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/about-us'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toIso8601String()],
            ['loc' => url('/contact-us'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toIso8601String()],
        ];

        // Published CMS Pages
        $cmsPages = Page::published()
            ->where('robots_index', true)
            ->get();

        foreach ($cmsPages as $page) {
            if (!in_array($page->slug, ['about-us', 'contact-us'])) {
                $urls[] = [
                    'loc' => url("/page/{$page->slug}"),
                    'lastmod' => $page->updated_at->toIso8601String(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            }
        }

        return $this->buildUrlSet($urls);
    }

    public function generatePlants(): string
    {
        $plants = Plant::published()
            ->where('robots_index', true)
            ->get();

        $urls = $plants->map(function ($plant) {
            return [
                'loc' => url("/plants/{$plant->slug}"),
                'lastmod' => $plant->updated_at->toIso8601String(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    public function generateCategories(): string
    {
        $categories = PlantCategory::active()
            ->where('robots_index', true)
            ->get();

        $urls = $categories->map(function ($cat) {
            return [
                'loc' => url("/plants?category={$cat->slug}"),
                'lastmod' => $cat->updated_at->toIso8601String(),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    public function generateProblems(): string
    {
        $problems = PlantProblem::active()
            ->where('robots_index', true)
            ->get();

        $urls = $problems->map(function ($prob) {
            return [
                'loc' => url("/plant-problems/{$prob->slug}"),
                'lastmod' => $prob->updated_at->toIso8601String(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    public function generateArticles(): string
    {
        return $this->generatePostsByType(PostType::ARTICLE);
    }

    public function generateGuides(): string
    {
        return $this->generatePostsByType(PostType::GUIDE);
    }

    public function generateNews(): string
    {
        return $this->generatePostsByType(PostType::NEWS);
    }

    protected function generatePostsByType(PostType $type): string
    {
        $posts = Post::published()
            ->ofType($type)
            ->where('robots_index', true)
            ->get();

        $prefix = $type->routePrefix();

        $urls = $posts->map(function ($post) use ($prefix) {
            return [
                'loc' => url("/{$prefix}/{$post->slug}"),
                'lastmod' => $post->updated_at->toIso8601String(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    public function generateProducts(): string
    {
        $products = \App\Models\Product::published()
            ->where('robots_index', true)
            ->get();

        $urls = $products->map(function ($product) {
            return [
                'loc' => url("/shop/products/{$product->slug}"),
                'lastmod' => $product->updated_at->toIso8601String(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    public function generateProductCategories(): string
    {
        $categories = \App\Models\ProductCategory::active()
            ->where('robots_index', true)
            ->get();

        $urls = $categories->map(function ($cat) {
            return [
                'loc' => url("/shop/category/{$cat->slug}"),
                'lastmod' => $cat->updated_at->toIso8601String(),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    public function generateContentCategories(): string
    {
        $categories = ContentCategory::active()
            ->where('robots_index', true)
            ->get();

        $urls = $categories->map(function ($cat) {
            return [
                'loc' => url("/articles/category/{$cat->slug}"),
                'lastmod' => $cat->updated_at->toIso8601String(),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        })->toArray();

        return $this->buildUrlSet($urls);
    }

    protected function buildUrlSet(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . ($url['lastmod'] ?? now()->toIso8601String()) . '</lastmod>';
            $xml .= '<changefreq>' . ($url['changefreq'] ?? 'weekly') . '</changefreq>';
            $xml .= '<priority>' . ($url['priority'] ?? '0.5') . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
