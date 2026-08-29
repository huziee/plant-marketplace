<?php

namespace App\Services;

use App\Models\PlantProblem;
use App\Models\UrlRedirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlantProblemService
{
    public function createProblem(array $problemData, array $symptoms = [], array $causes = [], array $treatments = [], array $preventions = []): PlantProblem
    {
        return DB::transaction(function () use ($problemData, $symptoms, $causes, $treatments, $preventions) {
            if (empty($problemData['slug'])) {
                $problemData['slug'] = Str::slug($problemData['name']);
            }

            $problem = PlantProblem::create($problemData);

            $this->syncDetails($problem, $symptoms, $causes, $treatments, $preventions);

            return $problem;
        });
    }

    public function updateProblem(PlantProblem $problem, array $problemData, array $symptoms = [], array $causes = [], array $treatments = [], array $preventions = []): PlantProblem
    {
        return DB::transaction(function () use ($problem, $problemData, $symptoms, $causes, $treatments, $preventions) {
            $oldSlug = $problem->slug;

            if (empty($problemData['slug'])) {
                $problemData['slug'] = Str::slug($problemData['name']);
            }

            if ($oldSlug && $oldSlug !== $problemData['slug']) {
                UrlRedirect::updateOrCreate(
                    ['old_url' => "/plant-problems/{$oldSlug}"],
                    ['new_url' => "/plant-problems/{$problemData['slug']}", 'status_code' => 301]
                );
            }

            $problem->update($problemData);

            $this->syncDetails($problem, $symptoms, $causes, $treatments, $preventions);

            return $problem;
        });
    }

    protected function syncDetails(PlantProblem $problem, array $symptoms, array $causes, array $treatments, array $preventions): void
    {
        if (isset($symptoms)) {
            $problem->symptoms()->delete();
            foreach ($symptoms as $index => $sym) {
                if (trim($sym)) {
                    $problem->symptoms()->create(['symptom' => trim($sym), 'sort_order' => $index]);
                }
            }
        }

        if (isset($causes)) {
            $problem->causes()->delete();
            foreach ($causes as $index => $cause) {
                if (trim($cause)) {
                    $problem->causes()->create(['cause' => trim($cause), 'sort_order' => $index]);
                }
            }
        }

        if (isset($treatments)) {
            $problem->treatments()->delete();
            foreach ($treatments as $index => $inst) {
                if (trim($inst)) {
                    $problem->treatments()->create(['instruction' => trim($inst), 'sort_order' => $index]);
                }
            }
        }

        if (isset($preventions)) {
            $problem->preventions()->delete();
            foreach ($preventions as $index => $prev) {
                if (trim($prev)) {
                    $problem->preventions()->create(['instruction' => trim($prev), 'sort_order' => $index]);
                }
            }
        }
    }
}
