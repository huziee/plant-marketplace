<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use App\Models\Post;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, SeoService $seoService)
    {
        $query = trim($request->input('q', ''));

        $seoService->setTitle($query !== '' ? "Search Results for '{$query}'" : "Search")
                   ->setDescription("Search plants, care guides, articles, and products on Plantaric.")
                   ->setCanonical(route('search.index'))
                   ->setRobots('noindex,follow');

        $plants = collect();
        $categories = collect();
        $problems = collect();
        $posts = collect();
        $products = collect();

        if ($query !== '') {
            // Search Products
            $products = \App\Models\Product::published()
                ->with(['category', 'featuredImage'])
                ->where(function ($pq) use ($query) {
                    $pq->where('name', 'like', "%{$query}%")
                       ->orWhere('sku', 'like', "%{$query}%")
                       ->orWhere('short_description', 'like', "%{$query}%");
                })
                ->take(8)
                ->get();

            // Search Plants
            $plants = Plant::published()
                ->with(['category', 'care', 'featuredImage'])
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('scientific_name', 'like', "%{$query}%")
                      ->orWhere('local_name', 'like', "%{$query}%")
                      ->orWhere('urdu_name', 'like', "%{$query}%")
                      ->orWhereHas('commonNames', function ($cq) use ($query) {
                          $cq->where('name', 'like', "%{$query}%");
                      });
                })
                ->take(8)
                ->get();

            // Search Categories
            $categories = PlantCategory::active()
                ->where('name', 'like', "%{$query}%")
                ->orWhere('short_description', 'like', "%{$query}%")
                ->take(6)
                ->get();

            // Search Posts (Articles, Guides, News)
            $posts = Post::published()
                ->with(['author', 'category', 'featuredImage'])
                ->where(function ($pq) use ($query) {
                    $pq->where('title', 'like', "%{$query}%")
                       ->orWhere('excerpt', 'like', "%{$query}%")
                       ->orWhere('content', 'like', "%{$query}%")
                       ->orWhereHas('tags', function ($tq) use ($query) {
                           $tq->where('name', 'like', "%{$query}%");
                       });
                })
                ->take(8)
                ->get();
        }

        return view('frontend.search', compact('query', 'plants', 'categories', 'problems', 'posts', 'products', 'seoService'));
    }
}
