<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use App\Models\Post;
use App\Services\PostService;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request, SeoService $seoService)
    {
        $query = Post::published()
            ->ofType(PostType::GUIDE)
            ->with(['author', 'category', 'featuredImage'])
            ->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('excerpt', 'like', "%{$s}%");
            });
        }

        $guides = $query->paginate(12)->withQueryString();
        $categories = ContentCategory::active()->whereIn('type', ['guide', 'all'])->get();
        $featuredGuide = Post::published()->ofType(PostType::GUIDE)->featured()->latest('published_at')->first();

        $seo = $seoService->generate(
            'Complete Plant Care Guides & Gardening Tutorials | Plantora',
            'Comprehensive step-by-step plant care guides, repotting instructions, pest treatment tutorials, and vegetable growing manuals.'
        );

        return view('frontend.guides.index', compact('guides', 'categories', 'featuredGuide', 'seo'));
    }

    public function show(string $slug, SeoService $seoService)
    {
        $post = Post::published()
            ->ofType(PostType::GUIDE)
            ->where('slug', $slug)
            ->with(['author.authorProfile', 'category', 'featuredImage', 'tags', 'plants', 'problems', 'sources'])
            ->firstOrFail();

        $sessionKey = "viewed_post_{$post->id}";
        if (!session()->has($sessionKey)) {
            $post->increment('views');
            session()->put($sessionKey, true);
        }

        $relatedPosts = $this->postService->getRelatedPosts($post);

        $seo = $seoService->generate(
            $post->seo_title ?: "{$post->title} | Plantora",
            $post->meta_description ?: ($post->excerpt ?: str($post->content)->stripTags()->limit(150)),
            $post->canonical_url ?: $post->public_url,
            $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : null
        );

        return view('frontend.guides.show', compact('post', 'relatedPosts', 'seo'));
    }
}
