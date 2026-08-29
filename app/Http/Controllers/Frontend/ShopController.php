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
                   ->setDescription('Browse our curated collection of indoor & outdoor plants, premium seeds, organic fertilizers, pots and tools.');

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

        return view('frontend.shop', compact('seoService', 'products', 'categories', 'featuredCollections'));
    }

    public function category(string $slug, SeoService $seoService)
    {
        $category = ProductCategory::active()->where('slug', $slug)->firstOrFail();

        $seoService->setTitle($category->seo_title ?: "Buy {$category->name} Online")
                   ->setDescription($category->meta_description ?: "Explore our collection of {$category->name}. Healthy, healthy plants and garden essentials shipped directly to your door.")
                   ->setCanonical(route('frontend.shop.category', $category->slug));

        $products = Product::published()
            ->where('product_category_id', $category->id)
            ->with(['featuredImage', 'reviews'])
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::active()->withCount('products')->get();

        return view('frontend.products.category', compact('category', 'products', 'categories', 'seoService'));
    }

    public function show(string $slug, SeoService $seoService)
    {
        $product = Product::published()
            ->where('slug', $slug)
            ->with(['category', 'featuredImage', 'images.media', 'plant.care', 'plantProblems', 'posts', 'variants.attributeValues.attribute', 'reviews.user', 'relatedProducts.featuredImage'])
            ->firstOrFail();

        $seoService->setTitle($product->seo_title ?: "{$product->name} - Plantora Shop")
                   ->setDescription($product->meta_description ?: ($product->short_description ?: "Buy {$product->name} online from Plantora."))
                   ->setCanonical(route('frontend.shop.product', $product->slug));

        // Generate Schema.org Product JSON-LD
        $schema = [
            '@@context' => 'https://schema.org/',
            '@@type' => 'Product',
            'name' => $product->name,
            'image' => $product->featuredImage ? asset('storage/' . $product->featuredImage->file_path) : null,
            'description' => strip_tags($product->short_description ?: $product->description),
            'sku' => $product->sku,
            'offers' => [
                '@@type' => 'Offer',
                'priceCurrency' => setting('shop_currency', 'PKR'),
                'price' => (float) $product->price,
                'availability' => $product->stock_status->value === 'in_stock' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'url' => route('frontend.shop.product', $product->slug),
            ],
        ];

        if ($product->reviews()->count() > 0) {
            $schema['aggregateRating'] = [
                '@@type' => 'AggregateRating',
                'ratingValue' => $product->average_rating,
                'reviewCount' => $product->review_count,
            ];
        }

        $seoService->setJsonLd($schema);

        return view('frontend.products.show', compact('product', 'seoService'));
    }
}
