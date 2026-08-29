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

        $seo = $seoService->generate(
            'Plant Encyclopedia — Discover & Grow Healthy Plants',
            'Search the comprehensive Plantora Plant Encyclopedia for care guides, watering schedules, sunlight requirements, and growing tips.',
            url('/plants')
        );

        return view('frontend.plants.index', compact('plants', 'categories', 'sunlightOptions', 'seo'));
    }

    public function show(Plant $plant, SeoService $seoService)
    {
        // Public security guard: guest cannot view draft plants
        if ($plant->status !== 'published') {
            abort(404);
        }

        $plant->load(['category', 'care', 'images.media', 'commonNames', 'seasons', 'problems.featuredImage', 'featuredImage']);

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

        $seoTitle = $plant->seo_title ?: "{$plant->name} Care Guide, Growing Tips & Problems | Plantora";
        $metaDesc = $plant->meta_description ?: ($plant->short_description ?: "Complete care guide for {$plant->name} ({$plant->scientific_name}). Learn watering, sunlight, soil requirements, and how to treat common problems.");

        $seo = $seoService->generate(
            $seoTitle,
            $metaDesc,
            $plant->canonical_url ?: url("/plants/{$plant->slug}"),
            $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : null
        );

        return view('frontend.plants.show', compact('plant', 'relatedPlants', 'seo'));
    }
}
