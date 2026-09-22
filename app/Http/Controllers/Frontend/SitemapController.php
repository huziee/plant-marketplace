<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;

class SitemapController extends Controller
{
    public function index(SitemapService $sitemapService)
    {
        return response($sitemapService->generateIndex(), 200)
            ->header('Content-Type', 'text/xml');
    }

    public function show(string $type, SitemapService $sitemapService)
    {
        $xml = match ($type) {
            'pages' => $sitemapService->generatePages(),
            'plants' => $sitemapService->generatePlants(),
            'plant-categories' => $sitemapService->generateCategories(),
            'articles' => $sitemapService->generateArticles(),
            'news' => $sitemapService->generateNews(),
            'content-categories' => $sitemapService->generateContentCategories(),
            'products' => $sitemapService->generateProducts(),
            'product-categories' => $sitemapService->generateProductCategories(),
            default => abort(404),
        };

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}
