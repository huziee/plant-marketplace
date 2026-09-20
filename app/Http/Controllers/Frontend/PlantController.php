<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\PlantCare;
use App\Models\PlantCategory;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index(Request $request, SeoService $seoService)
    {
        $query = Plant::published()->with(['category', 'care', 'featuredImage']);

        $seoService->setTitle('Plant Encyclopedia — Discover & Care Guides')
                   ->setDescription('Explore our comprehensive botanical encyclopedia with care guides, watering rules, light requirements and troubleshooting.')
                   ->setCanonical(route('plants.index'));

        if ($request->anyFilled(['category', 'difficulty', 'environment', 'sunlight', 'pet_safe', 'search'])) {
            $seoService->setRobots('noindex,follow');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        if ($request->filled('environment')) {
            if ($request->input('environment') === 'indoor') {
                $query->where('indoor', true);
            } elseif ($request->input('environment') === 'outdoor') {
                $query->where('outdoor', true);
            }
        }

        if ($request->filled('sunlight')) {
            $query->whereHas('care', function ($q) use ($request) {
                $q->where('sunlight_level', $request->input('sunlight'));
            });
        }

        if ($request->filled('pet_safe') && $request->input('pet_safe') == '1') {
            $query->where('pet_safe', true);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('scientific_name', 'like', "%{$search}%")
                  ->orWhere('local_name', 'like', "%{$search}%")
                  ->orWhereHas('commonNames', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $plants = $query->latest('published_at')->paginate(12)->withQueryString();
        $categories = PlantCategory::active()->orderBy('name')->get();
        $sunlightOptions = PlantCare::sunlightLabels();

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
                    'name' => 'Plants',
                    'item' => route('plants.index'),
                ],
            ],
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.plants.index', compact('plants', 'categories', 'sunlightOptions', 'seo', 'seoService'));
    }

    public function show(Plant $plant, SeoService $seoService)
    {
        // Public security guard: guest cannot view draft plants
        if ($plant->status !== 'published') {
            abort(404);
        }

        $plant->load([
            'category',
            'care',
            'images.media',
            'commonNames',
            'seasons',
            'problems' => function ($q) {
                $q->active()->with(['featuredImage', 'symptoms', 'causes', 'treatments', 'preventions', 'products.featuredImage']);
            },
            'featuredImage'
        ]);

        // Related Plants based on same category or environment
        $relatedPlants = Plant::published()
            ->where('id', '!=', $plant->id)
            ->where(function ($q) use ($plant) {
                if ($plant->plant_category_id) {
                    $q->where('plant_category_id', $plant->plant_category_id);
                }
                $q->orWhere('difficulty', $plant->difficulty);
            })
            ->limit(4)
            ->get();

        $seoService->forModel(
            $plant,
            "{$plant->name} Care Guide, Watering & Growing Tips",
            $plant->short_description ?: "Learn how to care for {$plant->name} ({$plant->scientific_name}) including watering, lighting, soil and common problems."
        )->setCanonical($plant->canonical_url ?: route('plants.show', $plant->slug))
         ->setOgType('article');

        // Plant / WebPage JSON-LD Schema
        $plantImage = $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : null;
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => "{$plant->name} Care Guide",
            'description' => strip_tags($plant->short_description ?: $plant->description ?: $plant->name),
            'url' => route('plants.show', $plant->slug),
            'image' => $plantImage,
        ]);

        // BreadcrumbList Schema
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
                'name' => 'Plants',
                'item' => route('plants.index'),
            ],
        ];

        $pos = 3;
        if ($plant->category) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $plant->category->name,
                'item' => route('plants.index', ['category' => $plant->category->slug]),
            ];
        }

        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => $plant->name,
            'item' => route('plants.show', $plant->slug),
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

        return view('frontend.plants.show', compact('plant', 'relatedPlants', 'seo', 'seoService'));
    }
}
