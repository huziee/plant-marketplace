<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductCategory::with(['parent', 'image']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $categories = $query->orderBy('sort_order')->paginate(15)->withQueryString();
        $parentCategories = ProductCategory::whereNull('parent_id')->get();

        return view('admin.product_categories.index', compact('categories', 'parentCategories'));
    }

    public function create()
    {
        $parentCategories = ProductCategory::whereNull('parent_id')->orderBy('name')->get();
        return view('admin.product_categories.create', compact('parentCategories'));
    }

    public function store(StoreProductCategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['is_featured'] = !empty($data['is_featured']);

        if ($request->hasFile('image')) {
            $media = app(\App\Services\MediaService::class)->upload($request->file('image'), $request->user()?->id, 'public', 'categories');
            $data['image_id'] = $media->id;
        }

        ProductCategory::create($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        $parentCategories = ProductCategory::where('id', '!=', $productCategory->id)->whereNull('parent_id')->orderBy('name')->get();
        return view('admin.product_categories.edit', compact('productCategory', 'parentCategories'));
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $data = $request->validated();
        $data['slug'] = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['is_featured'] = !empty($data['is_featured']);

        if ($request->hasFile('image')) {
            $media = app(\App\Services\MediaService::class)->upload($request->file('image'), $request->user()?->id, 'public', 'categories');
            $data['image_id'] = $media->id;
        }

        $productCategory->update($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with associated products.');
        }

        $productCategory->delete();
        return redirect()->route('admin.product-categories.index')->with('success', 'Category deleted successfully.');
    }
}
