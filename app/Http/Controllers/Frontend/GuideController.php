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

        $seoService->setTitle('Complete Plant Care Guides & Gardening Tutorials')
                   ->setDescription('Comprehensive step-by-step plant care guides, repotting instructions, pest treatment tutorials, and vegetable growing manuals.')
                   ->setCanonical(route('guides.index'));

        if ($request->anyFilled(['category', 'search'])) {
            $seoService->setRobots('noindex,follow');
        }

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

        // Breadcrumbs Schema
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Guides',
                    'item' => route('guides.index'),
                ],
            ],
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.guides.index', compact('guides', 'categories', 'featuredGuide', 'seo', 'seoService'));
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

        $seoService->forModel(
            $post,
            "{$post->title} - Plantaric Guides",
            $post->excerpt ?: str($post->content)->stripTags()->limit(150)
        )->setCanonical($post->canonical_url ?: route('guides.show', $post->slug))
         ->setOgType('article');

        // Article / HowTo JSON-LD Schema
        $postImage = $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : asset('images/plantaric-og.jpg');
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => strip_tags($post->excerpt ?: str($post->content)->stripTags()->limit(160)),
            'image' => [$postImage],
            'datePublished' => $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author?->name ?: 'Plantaric Team',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => setting('site_name', 'Plantaric'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/plantaric-logo.png'),
                ],
            ],
        ]);

        // Breadcrumbs Schema
        $breadcrumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Guides',
                'item' => route('guides.index'),
            ],
        ];

        $pos = 3;
        if ($post->category) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $post->category->name,
                'item' => route('content-categories.show', $post->category->slug),
            ];
        }

        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => $post->title,
            'item' => route('guides.show', $post->slug),
        ];

        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs,
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.guides.show', compact('post', 'relatedPosts', 'seo', 'seoService'));
    }
}
