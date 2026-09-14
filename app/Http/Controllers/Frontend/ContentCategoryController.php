<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use App\Models\Post;
use App\Services\SEO\SeoService;

class ContentCategoryController extends Controller
{
    public function show(string $slug, SeoService $seoService)
    {
        $category = ContentCategory::active()
            ->where('slug', $slug)
            ->with('featuredImage')
            ->firstOrFail();

        $posts = Post::published()
            ->where('content_category_id', $category->id)
            ->with(['author', 'featuredImage'])
            ->latest('published_at')
            ->paginate(12);

        $seoService->forModel(
            $category,
            "{$category->name} Articles & Guides",
            $category->description ?: "Browse all published articles, guides, and news under {$category->name} on Plantaric."
        )->setCanonical($category->canonical_url ?: route('content-categories.show', $category->slug));

        // Breadcrumbs Schema
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Articles', 'item' => route('articles.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $category->name, 'item' => route('content-categories.show', $category->slug)],
            ],
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.content_categories.show', compact('category', 'posts', 'seo', 'seoService'));
    }
}
