<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;
use App\Models\Plant;
use App\Models\PlantCategory;
use App\Models\PlantProblem;
use App\Services\PlantService;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index(Request $request)
    {
        $query = Plant::with('category', 'featuredImage');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('scientific_name', 'like', "%{$search}%")
                  ->orWhere('local_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('plant_category_id', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        $plants = $query->latest()->paginate(15)->withQueryString();

        return view('admin.plants.index', compact('plants'));
    }

    public function create()
    {
        $categories = PlantCategory::active()->orderBy('name')->get();
        $problems = PlantProblem::active()->orderBy('name')->get();

        return view('admin.plants.create', compact('categories', 'problems'));
    }

    public function store(StorePlantRequest $request, PlantService $plantService)
    {
        $validated = $request->validated();
        $careData = $validated['care'] ?? [];
        $commonNames = $validated['common_names'] ?? [];
        $problemIds = $validated['problem_ids'] ?? [];

        unset($validated['care'], $validated['common_names'], $validated['problem_ids']);

        $plant = $plantService->createPlant($validated, $careData, $commonNames, $problemIds);

        return redirect()->route('admin.plants.index')->with('success', 'Plant created successfully.');
    }

    public function edit(Plant $plant)
    {
        $plant->load('care', 'commonNames', 'images.media', 'problems');
        $categories = PlantCategory::active()->orderBy('name')->get();
        $problems = PlantProblem::active()->orderBy('name')->get();

        return view('admin.plants.edit', compact('plant', 'categories', 'problems'));
    }

    public function update(UpdatePlantRequest $request, Plant $plant, PlantService $plantService)
    {
        $validated = $request->validated();
        $careData = $validated['care'] ?? [];
        $commonNames = $validated['common_names'] ?? [];
        $problemIds = $validated['problem_ids'] ?? [];

        unset($validated['care'], $validated['common_names'], $validated['problem_ids']);

        $plantService->updatePlant($plant, $validated, $careData, $commonNames, $problemIds);

        return redirect()->route('admin.plants.index')->with('success', 'Plant updated successfully.');
    }

    public function duplicate(Request $request, Plant $plant, PlantService $plantService)
    {
        $newPlant = $plantService->duplicatePlant($plant);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Plant '{$plant->name}' duplicated successfully as draft.",
                'new_id' => $newPlant->id,
                'edit_url' => route('admin.plants.edit', $newPlant->id)
            ]);
        }

        return redirect()->route('admin.plants.edit', $newPlant->id)->with('success', 'Plant duplicated successfully as draft.');
    }

    public function destroy(Request $request, Plant $plant)
    {
        $plant->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => "Plant '{$plant->name}' deleted successfully."]);
        }

        return back()->with('success', 'Plant soft deleted successfully.');
    }
}
