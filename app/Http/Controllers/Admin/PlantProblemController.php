<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlantProblemRequest;
use App\Http\Requests\UpdatePlantProblemRequest;
use App\Models\PlantProblem;
use App\Services\PlantProblemService;
use Illuminate\Http\Request;

class PlantProblemController extends Controller
{
    public function index(Request $request)
    {
        $query = PlantProblem::with('featuredImage');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->input('search')}%");
        }

        if ($request->filled('problem_type')) {
            $query->where('problem_type', $request->input('problem_type'));
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->input('severity'));
        }

        $problems = $query->latest()->paginate(15)->withQueryString();

        return view('admin.plant_problems.index', compact('problems'));
    }

    public function create()
    {
        return view('admin.plant_problems.create');
    }

    public function store(StorePlantProblemRequest $request, PlantProblemService $problemService)
    {
        $validated = $request->validated();
        $symptoms = $validated['symptoms'] ?? [];
        $causes = $validated['causes'] ?? [];
        $treatments = $validated['treatments'] ?? [];
        $preventions = $validated['preventions'] ?? [];

        unset($validated['symptoms'], $validated['causes'], $validated['treatments'], $validated['preventions']);

        $problemService->createProblem($validated, $symptoms, $causes, $treatments, $preventions);

        return redirect()->route('admin.plant-problems.index')->with('success', 'Plant problem created successfully.');
    }

    public function edit(PlantProblem $plantProblem)
    {
        $plantProblem->load('symptoms', 'causes', 'treatments', 'preventions');

        return view('admin.plant_problems.edit', compact('plantProblem'));
    }

    public function update(UpdatePlantProblemRequest $request, PlantProblem $plantProblem, PlantProblemService $problemService)
    {
        $validated = $request->validated();
        $symptoms = $validated['symptoms'] ?? [];
        $causes = $validated['causes'] ?? [];
        $treatments = $validated['treatments'] ?? [];
        $preventions = $validated['preventions'] ?? [];

        unset($validated['symptoms'], $validated['causes'], $validated['treatments'], $validated['preventions']);

        $problemService->updateProblem($plantProblem, $validated, $symptoms, $causes, $treatments, $preventions);

        return redirect()->route('admin.plant-problems.index')->with('success', 'Plant problem updated successfully.');
    }

    public function destroy(PlantProblem $plantProblem)
    {
        $plantProblem->delete();

        return back()->with('success', 'Plant problem deleted successfully.');
    }
}
