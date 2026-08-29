<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\PostType;
use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use App\Models\Post;
use App\Services\SEO\SeoService;

class HomeController extends Controller
{
    public function index(SeoService $seoService)
    {
        $seoService->setTitle(setting('seo_title', 'Plantora — Plants, Nurseries & Garden Care'))
                   ->setDescription(setting('seo_description', 'Discover plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert growing advice.'));

        // Query real categories with published plant count
        $dbCategories = PlantCategory::active()
            ->withCount(['plants' => function ($q) {
                $q->published();
            }])
            ->where('is_featured', true)
            ->take(6)
            ->get();

        if ($dbCategories->count() > 0) {
            $categories = $dbCategories->map(function ($cat) {
                return [
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'count' => $cat->plants_count . ' plants',
                    'image' => $cat->image ? asset('storage/' . $cat->image->file_path) : 'https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?auto=format&fit=crop&w=500&q=80',
                ];
            })->toArray();
        } else {
            $categories = [
                ['name' => 'Indoor Plants', 'slug' => 'indoor-plants', 'count' => '184 plants', 'image' => 'https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?auto=format&fit=crop&w=500&q=80'],
                ['name' => 'Outdoor Plants', 'slug' => 'outdoor-plants', 'count' => '226 plants', 'image' => 'https://images.unsplash.com/photo-1591857177580-dc82b9ac4e1e?auto=format&fit=crop&w=500&q=80'],
                ['name' => 'Flowering Plants', 'slug' => 'flowering-plants', 'count' => '96 plants', 'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=500&q=80'],
                ['name' => 'Succulents & Cacti', 'slug' => 'succulents-cacti', 'count' => '312 plants', 'image' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=500&q=80'],
                ['name' => 'Herbs', 'slug' => 'herbs', 'count' => '124 plants', 'image' => 'https://images.unsplash.com/photo-1599685315640-9ceab2f581ca?auto=format&fit=crop&w=500&q=80'],
                ['name' => 'Vegetables', 'slug' => 'vegetables', 'count' => '168 plants', 'image' => 'https://images.unsplash.com/photo-1604762512526-b7ce049b5764?auto=format&fit=crop&w=500&q=80'],
            ];
        }

        // Query real published plants
        $dbPlants = Plant::published()
            ->with(['care', 'featuredImage', 'category'])
            ->where('is_featured', true)
            ->take(8)
            ->get();

        if ($dbPlants->count() > 0) {
            $trendingProducts = $dbPlants->map(function ($plant) {
                return [
                    'name' => $plant->name,
                    'slug' => $plant->slug,
                    'badge' => ucfirst($plant->difficulty) . ' Care',
                    'price' => 'Explore Care',
                    'original_price' => null,
                    'rating' => 5,
                    'reviews' => 98,
                    'light' => $plant->care?->sunlight_label ?: 'Medium Light',
                    'water' => $plant->care?->watering_label ?: 'Weekly',
                    'image' => $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85',
                ];
            })->toArray();
        } else {
            $trendingProducts = [
                ['name' => 'Monstera Deliciosa', 'slug' => 'monstera-deliciosa', 'badge' => 'Easy Care', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 128, 'light' => 'Medium light', 'water' => 'Weekly', 'image' => 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85'],
                ['name' => 'Snake Plant', 'slug' => 'snake-plant', 'badge' => 'Low Light', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 96, 'light' => 'Low light', 'water' => '2–3 weeks', 'image' => 'https://images.unsplash.com/photo-1593482892290-f54927ae2b7f?auto=format&fit=crop&w=700&q=85'],
                ['name' => 'Fiddle Leaf Fig', 'slug' => 'fiddle-leaf-fig', 'badge' => 'Moderate Care', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 4, 'reviews' => 74, 'light' => 'Bright light', 'water' => 'Weekly', 'image' => 'https://images.unsplash.com/photo-1601985705806-5b9a71f6004f?auto=format&fit=crop&w=700&q=85'],
                ['name' => 'Peace Lily', 'slug' => 'peace-lily', 'badge' => 'Air Purifying', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 110, 'light' => 'Indirect', 'water' => 'Weekly', 'image' => 'https://images.unsplash.com/photo-1597055181300-e3633a207517?auto=format&fit=crop&w=700&q=85'],
            ];
        }

        // Query real featured plant problems
        $featuredProblems = PlantProblem::active()->where('is_featured', true)->take(6)->get();

        // Query real Phase 3 Content: Featured Articles, Guides, and News
        $featuredArticles = Post::published()->ofType(PostType::ARTICLE)->with(['category', 'author', 'featuredImage'])->latest('published_at')->take(3)->get();
        $featuredGuides = Post::published()->ofType(PostType::GUIDE)->with(['category', 'author', 'featuredImage'])->latest('published_at')->take(3)->get();
        $latestNews = Post::published()->ofType(PostType::NEWS)->with(['category', 'author', 'featuredImage'])->latest('published_at')->take(4)->get();

        return view('frontend.home', compact('seoService', 'categories', 'trendingProducts', 'featuredProblems', 'featuredArticles', 'featuredGuides', 'latestNews'));
    }
}
