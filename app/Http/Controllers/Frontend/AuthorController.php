<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\SEO\SeoService;

class AuthorController extends Controller
{
    public function show(User $user, SeoService $seoService)
    {
        $user->load('authorProfile.profileImage');

        $posts = Post::published()
            ->where('author_id', $user->id)
            ->with(['category', 'featuredImage'])
            ->latest('published_at')
            ->paginate(12);

        $seoService->setTitle("Articles by {$user->name} | Author Profile")
                   ->setDescription($user->authorProfile?->bio ?: "Read botanical articles, plant guides, and gardening tips authored by {$user->name} on Plantaric.")
                   ->setCanonical(route('authors.show', $user->id));

        // Person JSON-LD Schema
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $user->name,
            'description' => $user->authorProfile?->bio ?: "Author at Plantaric",
            'url' => route('authors.show', $user->id),
            'jobTitle' => $user->authorProfile?->job_title ?: 'Botanical Writer & Plant Expert',
        ]);

        // Breadcrumbs Schema
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Authors', 'item' => url('/articles')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $user->name, 'item' => route('authors.show', $user->id)],
            ],
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.authors.show', compact('user', 'posts', 'seo', 'seoService'));
    }
}
