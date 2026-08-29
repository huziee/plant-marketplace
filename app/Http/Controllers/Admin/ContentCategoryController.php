<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentCategoryRequest;
use App\Http\Requests\UpdateContentCategoryRequest;
use App\Models\ContentCategory;
use App\Models\Media;
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
        $mediaFiles = Media::latest()->take(30)->get();

        return view('admin.content_categories.create', compact('parents', 'mediaFiles'));
    }

    public function store(StoreContentCategoryRequest $request)
    {
        $category = ContentCategory::create($request->validated());

        return redirect()->route('admin.content-categories.index')
            ->with('success', "Content Category '{$category->name}' created successfully.");
    }

    public function edit(ContentCategory $contentCategory)
    {
        $parents = ContentCategory::whereNull('parent_id')->where('id', '!=', $contentCategory->id)->get();
        $mediaFiles = Media::latest()->take(30)->get();

        return view('admin.content_categories.edit', compact('contentCategory', 'parents', 'mediaFiles'));
    }

    public function update(UpdateContentCategoryRequest $request, ContentCategory $contentCategory)
    {
        $contentCategory->update($request->validated());

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
