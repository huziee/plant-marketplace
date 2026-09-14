<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCollection;
use App\Services\SEO\SeoService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, SeoService $seoService)
    {
        $seoService->setTitle('Shop Healthy Plants & Garden Supplies')
                   ->setDescription('Browse our curated collection of indoor & outdoor plants, premium seeds, organic fertilizers, pots and tools.')
                   ->setCanonical(route('shop.index'));

        // Filter / sort parameter SEO policy:
        // Filtered or sorted parameter combinations should be noindexed to prevent duplicate parameter indexing.
        if ($request->anyFilled(['search', 'category', 'type', 'sort', 'min_price', 'max_price', 'stock'])) {
            $seoService->setRobots('noindex,follow');
        }

        $query = Product::published()->with(['category', 'featuredImage', 'reviews']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        if ($request->filled('type')) {
            $query->where('product_type', $request->input('type'));
        }

        if ($request->filled('sort')) {
            match ($request->input('sort')) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest(),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = ProductCategory::active()->withCount('products')->orderBy('sort_order')->get();
        $featuredCollections = ProductCollection::active()->where('is_featured', true)->with('image')->get();

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
                    'name' => 'Shop',
                    'item' => route('shop.index'),
                ],
            ],
        ]);

        return view('frontend.shop', compact('seoService', 'products', 'categories', 'featuredCollections'));
    }

    public function category(string $slug, Request $request, SeoService $seoService)
    {
        $category = ProductCategory::active()->where('slug', $slug)->firstOrFail();

        $seoService->forModel(
            $category,
            "Buy {$category->name} Online",
            "Explore our collection of {$category->name}. Healthy plants and garden essentials shipped directly to your door."
        )->setCanonical(route('frontend.shop.category', $category->slug));

        if ($request->anyFilled(['sort', 'min_price', 'max_price', 'stock', 'type'])) {
            $seoService->setRobots('noindex,follow');
        }

        $products = Product::published()
            ->where('product_category_id', $category->id)
            ->with(['featuredImage', 'reviews'])
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::active()->withCount('products')->get();

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
                    'name' => 'Shop',
                    'item' => route('shop.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $category->name,
                    'item' => route('frontend.shop.category', $category->slug),
                ],
            ],
        ]);

        return view('frontend.products.category', compact('category', 'products', 'categories', 'seoService'));
    }

    public function show(string $slug, SeoService $seoService)
    {
        $product = Product::published()
            ->where('slug', $slug)
            ->with(['category', 'featuredImage', 'images.media', 'plant.care', 'plantProblems', 'posts', 'variants.attributeValues.attribute', 'reviews.user', 'relatedProducts.featuredImage'])
            ->firstOrFail();

        $seoService->forModel(
            $product,
            "{$product->name} - Plantaric Store",
            $product->short_description ?: "Buy {$product->name} online from Plantaric."
        )->setCanonical(route('frontend.shop.product', $product->slug))
         ->setOgType('product');

        // Product JSON-LD Schema
        $images = [];
        if ($product->featuredImage) {
            $images[] = asset('storage/' . $product->featuredImage->file_path);
        }
        foreach ($product->images as $img) {
            if ($img->media) {
                $images[] = asset('storage/' . $img->media->file_path);
            }
        }

        $stockAvailability = is_object($product->stock_status) ? $product->stock_status->value : (string) $product->stock_status;
        $availabilityUrl = ($stockAvailability === 'in_stock' || $stockAvailability === 'instock') 
            ? 'https://schema.org/InStock' 
            : 'https://schema.org/OutOfStock';

        $productSchema = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => array_values(array_unique($images)),
            'description' => strip_tags($product->short_description ?: $product->description ?: $product->name),
            'sku' => $product->sku,
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => setting('currency', 'PKR'),
                'price' => (float) $product->price,
                'availability' => $availabilityUrl,
                'url' => route('frontend.shop.product', $product->slug),
            ],
        ];

        if (!empty($product->brand_name)) {
            $productSchema['brand'] = [
                '@type' => 'Brand',
                'name' => $product->brand_name,
            ];
        } elseif ($product->category) {
            $productSchema['brand'] = [
                '@type' => 'Brand',
                'name' => setting('site_name', 'Plantaric'),
            ];
        }

        if (!empty($product->gtin)) {
            $productSchema['gtin'] = $product->gtin;
        }

        if (!empty($product->mpn)) {
            $productSchema['mpn'] = $product->mpn;
        }

        if ($product->reviews()->count() > 0) {
            $productSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => (float) $product->average_rating,
                'reviewCount' => (int) $product->review_count,
            ];
        }

        $seoService->addJsonLd($productSchema);

        // BreadcrumbList Schema
        $breadcrumbItems = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Shop',
                'item' => route('shop.index'),
            ],
        ];

        $pos = 3;
        if ($product->category) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $product->category->name,
                'item' => route('frontend.shop.category', $product->category->slug),
            ];
        }

        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => $product->name,
            'item' => route('frontend.shop.product', $product->slug),
        ];

        $seoService->addJsonLd([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbItems,
        ]);

        return view('frontend.products.show', compact('product', 'seoService'));
    }
}
