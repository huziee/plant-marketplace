<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PlantProblem;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class PlantProblemController extends Controller
{
    public function index(Request $request, SeoService $seoService)
    {
        $query = PlantProblem::active()->with('featuredImage');

        if ($request->filled('type')) {
            $query->where('problem_type', $request->input('type'));
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->input('severity'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $problems = $query->latest()->paginate(12)->withQueryString();

        $seo = $seoService->generate(
            'Plant Doctor — Symptoms, Causes & Treatments | Plantora',
            'Identify plant diseases, leaf yellowing, pests, and root problems with expert treatment and prevention steps.',
            url('/plant-problems')
        );

        return view('frontend.problems.index', compact('problems', 'seo'));
    }

    public function show(PlantProblem $plantProblem, SeoService $seoService)
    {
        if ($plantProblem->status !== 'active') {
            abort(404);
        }

        $plantProblem->load(['symptoms', 'causes', 'treatments', 'preventions', 'featuredImage', 'plants.featuredImage']);

        $seoTitle = $plantProblem->seo_title ?: "{$plantProblem->name}: Causes, Treatment & Prevention | Plantora";
        $metaDesc = $plantProblem->meta_description ?: ($plantProblem->short_description ?: "How to fix {$plantProblem->name}. Learn symptoms, underlying causes, step-by-step treatment guidance, and prevention tips.");

        $seo = $seoService->generate(
            $seoTitle,
            $metaDesc,
            $plantProblem->canonical_url ?: url("/plant-problems/{$plantProblem->slug}"),
            $plantProblem->featuredImage ? asset('storage/' . $plantProblem->featuredImage->file_path) : null
        );

        return view('frontend.problems.show', compact('plantProblem', 'seo'));
    }
}
