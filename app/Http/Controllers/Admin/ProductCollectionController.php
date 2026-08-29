<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCollectionController extends Controller
{
    public function index()
    {
        $collections = ProductCollection::withCount('products')->orderBy('sort_order')->paginate(15);
        return view('admin.collections.index', compact('collections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_collections,slug',
            'description' => 'nullable|string',
            'image_id' => 'nullable|exists:media,id',
            'status' => 'required|string|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['is_featured'] = !empty($data['is_featured']);

        ProductCollection::create($data);

        return redirect()->route('admin.product-collections.index')->with('success', 'Collection created successfully.');
    }

    public function destroy(ProductCollection $productCollection)
    {
        $productCollection->delete();
        return redirect()->route('admin.product-collections.index')->with('success', 'Collection deleted successfully.');
    }
}
