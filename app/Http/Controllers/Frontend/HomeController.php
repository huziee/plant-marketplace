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
        $siteName = setting('site_name', 'Plantaric');
        $seoService->setTitle(setting('seo_title', 'Plantaric — Agriculture, Plants & Botanical Care'))
                   ->setDescription(setting('seo_description', 'Discover agricultural plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert botanical advice.'))
                   ->setCanonical(url('/'));

        // Organization & WebSite JSON-LD
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
            'logo' => asset('images/plantaric-logo.png'),
            'sameAs' => array_values(array_filter([
                setting('facebook_url'),
                setting('instagram_url'),
                setting('youtube_url'),
                setting('pinterest_url'),
            ])),
        ]);

        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/search') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ]);

        // Query real categories with published plant count
        $dbCategories = PlantCategory::active()
            ->with(['image'])
            ->withCount(['plants' => function ($q) {
                $q->published();
            }])
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $categoryImagesMap = [
            'indoor-plants' => asset('images/categories/indoor_plants.jpg'),
            'outdoor-plants' => asset('images/categories/outdoor_plants.jpg'),
            'flowering-plants' => asset('images/categories/flowering_plants.jpg'),
            'succulents-cacti' => asset('images/categories/succulents_cacti.jpg'),
            'herbs' => asset('images/categories/herbs.jpg'),
            'vegetables' => asset('images/categories/vegetables.jpg'),
        ];

        if ($dbCategories->count() > 0) {
            $categories = $dbCategories->map(function ($cat) use ($categoryImagesMap) {
                return [
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'count' => $cat->plants_count . ' plants',
                    'image' => $cat->image ? asset('storage/' . $cat->image->file_path) : ($categoryImagesMap[$cat->slug] ?? asset('images/categories/indoor_plants.jpg')),
                ];
            })->toArray();
        } else {
            $categories = [
                ['name' => 'Indoor Plants', 'slug' => 'indoor-plants', 'count' => '184 plants', 'image' => asset('images/categories/indoor_plants.jpg')],
                ['name' => 'Outdoor Plants', 'slug' => 'outdoor-plants', 'count' => '226 plants', 'image' => asset('images/categories/outdoor_plants.jpg')],
                ['name' => 'Flowering Plants', 'slug' => 'flowering-plants', 'count' => '96 plants', 'image' => asset('images/categories/flowering_plants.jpg')],
                ['name' => 'Succulents & Cacti', 'slug' => 'succulents-cacti', 'count' => '312 plants', 'image' => asset('images/categories/succulents_cacti.jpg')],
                ['name' => 'Herbs', 'slug' => 'herbs', 'count' => '124 plants', 'image' => asset('images/categories/herbs.jpg')],
                ['name' => 'Vegetables', 'slug' => 'vegetables', 'count' => '168 plants', 'image' => asset('images/categories/vegetables.jpg')],
            ];
        }

        // Query real published plants
        $dbPlants = Plant::published()
            ->with(['care', 'featuredImage', 'category'])
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $tableImagesList = [
            asset('images/products/monstera_table.jpg'),
            asset('images/products/snake_table.jpg'),
            asset('images/products/fiddle_table.jpg'),
            asset('images/products/peace_table.jpg'),
            asset('images/products/pothos_table.jpg'),
            asset('images/products/rubber_table.jpg'),
            asset('images/products/zz_table.jpg'),
            asset('images/products/calathea_table.jpg'),
        ];

        if ($dbPlants->count() > 0) {
            $trendingProducts = $dbPlants->values()->map(function ($plant, $index) use ($tableImagesList) {
                return [
                    'name' => $plant->name,
                    'slug' => $plant->slug,
                    'badge' => ucfirst($plant->difficulty) . ' Care',
                    'price' => 'Explore Care',
                    'original_price' => null,
                    'rating' => 5,
                    'reviews' => 85 + ($index * 12),
                    'light' => $plant->care?->sunlight_label ?: 'Medium Light',
                    'water' => $plant->care?->watering_label ?: 'Weekly',
                    'image' => $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : $tableImagesList[$index % count($tableImagesList)],
                ];
            })->toArray();
        } else {
            $trendingProducts = [
                ['name' => 'Monstera Deliciosa', 'slug' => 'monstera-deliciosa', 'badge' => 'Easy Care', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 128, 'light' => 'Medium light', 'water' => 'Weekly', 'image' => $tableImagesList[0]],
                ['name' => 'Snake Plant', 'slug' => 'snake-plant', 'badge' => 'Low Light', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 96, 'light' => 'Low light', 'water' => '2–3 weeks', 'image' => $tableImagesList[1]],
                ['name' => 'Fiddle Leaf Fig', 'slug' => 'fiddle-leaf-fig', 'badge' => 'Moderate Care', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 4, 'reviews' => 74, 'light' => 'Bright light', 'water' => 'Weekly', 'image' => $tableImagesList[2]],
                ['name' => 'Peace Lily', 'slug' => 'peace-lily', 'badge' => 'Air Purifying', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 110, 'light' => 'Indirect', 'water' => 'Weekly', 'image' => $tableImagesList[3]],
                ['name' => 'Golden Pothos', 'slug' => 'golden-pothos', 'badge' => 'Beginner Friendly', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 142, 'light' => 'Low to Bright', 'water' => 'Weekly', 'image' => $tableImagesList[4]],
                ['name' => 'Rubber Tree Plant', 'slug' => 'rubber-plant', 'badge' => 'Glossy Leaves', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 88, 'light' => 'Bright light', 'water' => '1–2 weeks', 'image' => $tableImagesList[5]],
                ['name' => 'ZZ Plant', 'slug' => 'zz-plant', 'badge' => 'Drought Tolerant', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 5, 'reviews' => 105, 'light' => 'Low light', 'water' => '2–3 weeks', 'image' => $tableImagesList[6]],
                ['name' => 'Calathea Orbifolia', 'slug' => 'calathea-orbifolia', 'badge' => 'Pet Friendly', 'price' => 'Explore Care', 'original_price' => null, 'rating' => 4, 'reviews' => 69, 'light' => 'Medium light', 'water' => 'Twice weekly', 'image' => $tableImagesList[7]],
            ];
        }

        // Query real Phase 3 Content: Featured Articles, Guides, and News
        $featuredArticles = Post::published()->ofType(PostType::ARTICLE)->with(['category', 'author', 'featuredImage'])->latest('published_at')->take(3)->get();
        $featuredGuides = Post::published()->ofType(PostType::GUIDE)->with(['category', 'author', 'featuredImage'])->latest('published_at')->take(3)->get();
        $latestNews = Post::published()->ofType(PostType::NEWS)->with(['category', 'author', 'featuredImage'])->latest('published_at')->take(4)->get();

        // Dynamic stats counts
        $plantsCount = Plant::published()->count();
        $categoriesCount = PlantCategory::active()->count();
        $articlesCount = Post::published()->ofType(PostType::ARTICLE)->count();

        return view('frontend.home', compact(
            'seoService',
            'categories',
            'trendingProducts',
            'featuredArticles',
            'featuredGuides',
            'latestNews',
            'plantsCount',
            'categoriesCount',
            'articlesCount'
        ));
    }
}
