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

        $seo = $seoService->generate(
            "Articles by {$user->name} | Plantora Author",
            $user->authorProfile?->bio ?: "Read botanical articles, plant guides, and gardening tips authored by {$user->name} on Plantora."
        );

        return view('frontend.authors.show', compact('user', 'posts', 'seo'));
    }
}
