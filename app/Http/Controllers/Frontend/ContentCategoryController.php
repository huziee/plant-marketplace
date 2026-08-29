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

        $seo = $seoService->generate(
            $category->seo_title ?: "{$category->name} Articles & Guides | Plantora",
            $category->meta_description ?: ($category->description ?: "Browse all published articles, guides, and news under {$category->name} on Plantora."),
            $category->canonical_url ?: url("/articles/category/{$category->slug}"),
            $category->featuredImage ? asset('storage/' . $category->featuredImage->file_path) : null
        );

        return view('frontend.content_categories.show', compact('category', 'posts', 'seo'));
    }
}
