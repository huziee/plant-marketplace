<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use App\Models\Post;
use App\Services\PostService;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request, SeoService $seoService)
    {
        $query = Post::published()
            ->ofType(PostType::NEWS)
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

        $newsPosts = $query->paginate(12)->withQueryString();
        $categories = ContentCategory::active()->whereIn('type', ['news', 'all'])->get();
        $featuredNews = Post::published()->ofType(PostType::NEWS)->featured()->latest('published_at')->first();

        $seo = $seoService->generate(
            'Plant News & Botanical Industry Updates | Plantora',
            'Stay updated with the latest plant science developments, urban farming news, regional agriculture updates, and nursery industry trends.'
        );

        return view('frontend.news.index', compact('newsPosts', 'categories', 'featuredNews', 'seo'));
    }

    public function show(string $slug, SeoService $seoService)
    {
        $post = Post::published()
            ->ofType(PostType::NEWS)
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

        return view('frontend.news.show', compact('post', 'relatedPosts', 'seo'));
    }
}
