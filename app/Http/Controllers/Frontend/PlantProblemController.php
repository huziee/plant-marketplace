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

        $seoService->setTitle('Plant Doctor — Symptoms, Causes & Treatments')
                   ->setDescription('Identify plant diseases, leaf yellowing, pests, and root problems with expert treatment and prevention steps.')
                   ->setCanonical(route('problems.index'));

        if ($request->anyFilled(['type', 'severity', 'search'])) {
            $seoService->setRobots('noindex,follow');
        }

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

        // Breadcrumbs Schema
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Plant Problems', 'item' => route('problems.index')],
            ],
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.problems.index', compact('problems', 'seo', 'seoService'));
    }

    public function show(PlantProblem $plantProblem, SeoService $seoService)
    {
        if ($plantProblem->status !== 'active') {
            abort(404);
        }

        $plantProblem->load(['symptoms', 'causes', 'treatments', 'preventions', 'featuredImage', 'plants.featuredImage']);

        $seoService->forModel(
            $plantProblem,
            "{$plantProblem->name}: Causes, Treatment & Prevention",
            $plantProblem->short_description ?: "How to fix {$plantProblem->name}. Learn symptoms, underlying causes, treatment guidance, and prevention tips."
        )->setCanonical($plantProblem->canonical_url ?: route('problems.show', $plantProblem->slug))
         ->setOgType('article');

        // WebPage / Article Schema
        $problemImage = $plantProblem->featuredImage ? asset('storage/' . $plantProblem->featuredImage->file_path) : null;
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => "{$plantProblem->name} Solution & Care Guide",
            'description' => strip_tags($plantProblem->short_description ?: $plantProblem->description ?: $plantProblem->name),
            'image' => $problemImage ? [$problemImage] : [],
            'datePublished' => $plantProblem->created_at->toIso8601String(),
            'dateModified' => $plantProblem->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => setting('site_name', 'Plantaric'),
            ],
        ]);

        // Breadcrumbs Schema
        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Plant Problems', 'item' => route('problems.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $plantProblem->name, 'item' => route('problems.show', $plantProblem->slug)],
            ],
        ]);

        $seo = [
            'title' => $seoService->getTitle(),
            'description' => $seoService->getDescription(),
        ];

        return view('frontend.problems.show', compact('plantProblem', 'seo', 'seoService'));
    }
}
