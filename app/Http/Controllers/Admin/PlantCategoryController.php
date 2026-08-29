<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlantCategoryRequest;
use App\Http\Requests\UpdatePlantCategoryRequest;
use App\Models\PlantCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlantCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PlantCategory::with('parent', 'image');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->input('search')}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $categories = $query->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.plant_categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = PlantCategory::active()->whereNull('parent_id')->get();
        return view('admin.plant_categories.create', compact('parents'));
    }

    public function store(StorePlantCategoryRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        PlantCategory::create($data);

        return redirect()->route('admin.plant-categories.index')->with('success', 'Plant category created successfully.');
    }

    public function edit(PlantCategory $plantCategory)
    {
        $parents = PlantCategory::active()->where('id', '!=', $plantCategory->id)->get();
        return view('admin.plant_categories.edit', compact('plantCategory', 'parents'));
    }

    public function update(UpdatePlantCategoryRequest $request, PlantCategory $plantCategory)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $plantCategory->update($data);

        return redirect()->route('admin.plant-categories.index')->with('success', 'Plant category updated successfully.');
    }

    public function destroy(PlantCategory $plantCategory)
    {
        if ($plantCategory->plants()->count() > 0) {
            return back()->with('error', 'Cannot delete category containing associated plants.');
        }

        $plantCategory->delete();

        return back()->with('success', 'Plant category deleted successfully.');
    }
}
