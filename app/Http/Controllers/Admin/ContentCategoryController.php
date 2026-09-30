<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentCategoryRequest;
use App\Http\Requests\UpdateContentCategoryRequest;
use App\Models\ContentCategory;
use Illuminate\Http\Request;

class ContentCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = ContentCategory::with(['parent', 'featuredImage'])
            ->withCount('posts')
            ->orderBy('sort_order')
            ->get();

        return view('admin.content_categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = ContentCategory::whereNull('parent_id')->get();

        return view('admin.content_categories.create', compact('parents'));
    }

    public function store(StoreContentCategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $media = app(\App\Services\MediaService::class)->upload($request->file('image'), $request->user()?->id, 'public', 'categories');
            $data['featured_image_id'] = $media->id;
        }

        $category = ContentCategory::create($data);

        return redirect()->route('admin.content-categories.index')
            ->with('success', "Content Category '{$category->name}' created successfully.");
    }

    public function edit(ContentCategory $contentCategory)
    {
        $contentCategory->load('featuredImage');
        $parents = ContentCategory::whereNull('parent_id')->where('id', '!=', $contentCategory->id)->get();

        return view('admin.content_categories.edit', compact('contentCategory', 'parents'));
    }

    public function update(UpdateContentCategoryRequest $request, ContentCategory $contentCategory)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $media = app(\App\Services\MediaService::class)->upload($request->file('image'), $request->user()?->id, 'public', 'categories');
            $data['featured_image_id'] = $media->id;
        }

        $contentCategory->update($data);

        return redirect()->route('admin.content-categories.index')
            ->with('success', "Content Category '{$contentCategory->name}' updated successfully.");
    }

    public function destroy(ContentCategory $contentCategory)
    {
        $contentCategory->delete();

        return redirect()->route('admin.content-categories.index')
            ->with('success', "Content Category deleted successfully.");
    }
}
