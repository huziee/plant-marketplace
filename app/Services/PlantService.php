<?php

namespace App\Services;

use App\Models\Plant;
use App\Models\PlantCare;
use App\Models\UrlRedirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlantService
{
    /**
     * Store a new plant record with care data, common names, and problem links in a transaction.
     */
    public function createPlant(array $plantData, array $careData = [], array $commonNames = [], array $problemIds = []): Plant
    {
        return DB::transaction(function () use ($plantData, $careData, $commonNames, $problemIds) {
            if (empty($plantData['slug'])) {
                $plantData['slug'] = Str::slug($plantData['name']);
            }

            $plantData['created_by'] = auth()->id();
            $plant = Plant::create($plantData);

            // Create PlantCare
            if (!empty($careData)) {
                $plant->care()->create($careData);
            }

            // Sync Common Names
            if (!empty($commonNames)) {
                foreach ($commonNames as $name) {
                    if (trim($name)) {
                        $plant->commonNames()->create(['name' => trim($name)]);
                    }
                }
            }

            // Sync Problems
            if (!empty($problemIds)) {
                $plant->problems()->sync($problemIds);
            }

            return $plant;
        });
    }

    /**
     * Update an existing plant record and manage 301 redirects if slug changes.
     */
    public function updatePlant(Plant $plant, array $plantData, array $careData = [], array $commonNames = [], array $problemIds = []): Plant
    {
        return DB::transaction(function () use ($plant, $plantData, $careData, $commonNames, $problemIds) {
            $oldSlug = $plant->slug;

            if (empty($plantData['slug'])) {
                $plantData['slug'] = Str::slug($plantData['name']);
            }

            // If slug changed, create 301 Redirect for SEO preservation
            if ($oldSlug && $oldSlug !== $plantData['slug']) {
                UrlRedirect::updateOrCreate(
                    ['old_url' => "/plants/{$oldSlug}"],
                    ['new_url' => "/plants/{$plantData['slug']}", 'status_code' => 301]
                );
            }

            $plantData['updated_by'] = auth()->id();
            $plant->update($plantData);

            // Update or Create Care
            if (!empty($careData)) {
                $plant->care()->updateOrCreate(['plant_id' => $plant->id], $careData);
            }

            // Refresh Common Names
            if (isset($commonNames)) {
                $plant->commonNames()->delete();
                foreach ($commonNames as $name) {
                    if (trim($name)) {
                        $plant->commonNames()->create(['name' => trim($name)]);
                    }
                }
            }

            // Sync Problems
            if (isset($problemIds)) {
                $plant->problems()->sync($problemIds);
            }

            return $plant;
        });
    }

    /**
     * Duplicate a plant record as draft with a new slug.
     */
    public function duplicatePlant(Plant $originalPlant): Plant
    {
        return DB::transaction(function () use ($originalPlant) {
            $newPlant = $originalPlant->replicate();
            $newPlant->name = $originalPlant->name . ' Copy';
            $newPlant->slug = Str::slug($newPlant->name . '-' . time());
            $newPlant->status = 'draft';
            $newPlant->is_featured = false;
            $newPlant->published_at = null;
            $newPlant->created_by = auth()->id();
            $newPlant->save();

            // Duplicate Care
            if ($originalPlant->care) {
                $newCare = $originalPlant->care->replicate();
                $newCare->plant_id = $newPlant->id;
                $newCare->save();
            }

            // Duplicate Common Names
            foreach ($originalPlant->commonNames as $cn) {
                $newPlant->commonNames()->create(['name' => $cn->name, 'language' => $cn->language]);
            }

            // Duplicate Image associations
            foreach ($originalPlant->images as $img) {
                $newPlant->images()->create([
                    'media_id' => $img->media_id,
                    'caption' => $img->caption,
                    'alt_text' => $img->alt_text,
                    'sort_order' => $img->sort_order,
                    'is_primary' => $img->is_primary,
                ]);
            }

            // Duplicate Problem links
            $pivotData = [];
            foreach ($originalPlant->problems as $prob) {
                $pivotData[$prob->id] = [
                    'frequency' => $prob->pivot->frequency,
                    'notes' => $prob->pivot->notes,
                ];
            }
            $newPlant->problems()->sync($pivotData);

            return $newPlant;
        });
    }
}
