<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $plant = $this->route('plant');

        return [
            // General
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('plants')->ignore($plant->id)],
            'plant_category_id' => ['nullable', 'exists:plant_categories,id'],
            'scientific_name' => ['nullable', 'string', 'max:255'],
            'family' => ['nullable', 'string', 'max:255'],
            'genus' => ['nullable', 'string', 'max:255'],
            'species' => ['nullable', 'string', 'max:255'],
            'local_name' => ['nullable', 'string', 'max:255'],
            'urdu_name' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'plant_type' => ['nullable', 'string', 'max:100'],
            'difficulty' => ['required', Rule::in(['easy', 'moderate', 'advanced'])],
            'growth_rate' => ['required', Rule::in(['slow', 'medium', 'fast'])],
            'lifespan_type' => ['nullable', 'string', 'max:100'],
            'origin' => ['nullable', 'string', 'max:255'],

            'mature_height_min' => ['nullable', 'numeric', 'min:0'],
            'mature_height_max' => ['nullable', 'numeric', 'min:0'],
            'mature_width_min' => ['nullable', 'numeric', 'min:0'],
            'mature_width_max' => ['nullable', 'numeric', 'min:0'],
            'measurement_unit' => ['nullable', 'string', 'max:20'],

            'indoor' => ['nullable', 'boolean'],
            'outdoor' => ['nullable', 'boolean'],
            'pet_safe' => ['nullable', 'boolean'],
            'air_purifying' => ['nullable', 'boolean'],
            'flowering' => ['nullable', 'boolean'],
            'edible' => ['nullable', 'boolean'],
            'medicinal' => ['nullable', 'boolean'],

            'featured_image_id' => ['nullable', 'exists:media,id'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],

            // Care fields
            'care.sunlight_level' => ['nullable', Rule::in(['full_sun', 'partial_sun', 'bright_indirect', 'medium_indirect', 'low_light', 'shade'])],
            'care.sunlight_description' => ['nullable', 'string'],
            'care.watering_frequency' => ['nullable', Rule::in(['daily', 'every_2_3_days', 'weekly', 'every_7_10_days', 'every_2_weeks', 'every_3_weeks', 'monthly', 'when_soil_dries', 'custom'])],
            'care.watering_description' => ['nullable', 'string'],
            'care.soil_type' => ['nullable', 'string', 'max:255'],
            'care.soil_ph_min' => ['nullable', 'numeric', 'between:0,14'],
            'care.soil_ph_max' => ['nullable', 'numeric', 'between:0,14'],
            'care.humidity_min' => ['nullable', 'integer', 'between:0,100'],
            'care.humidity_max' => ['nullable', 'integer', 'between:0,100'],
            'care.temperature_min' => ['nullable', 'integer', 'between:-50,60'],
            'care.temperature_max' => ['nullable', 'integer', 'between:-50,60'],
            'care.temperature_unit' => ['nullable', 'string', 'max:5'],
            'care.fertilizer_type' => ['nullable', 'string', 'max:255'],
            'care.fertilizer_frequency' => ['nullable', 'string', 'max:255'],
            'care.fertilizer_description' => ['nullable', 'string'],
            'care.pruning_description' => ['nullable', 'string'],
            'care.repotting_frequency' => ['nullable', 'string', 'max:255'],
            'care.repotting_description' => ['nullable', 'string'],
            'care.propagation_description' => ['nullable', 'string'],
            'care.dormancy_notes' => ['nullable', 'string'],
            'care.care_tips' => ['nullable', 'string'],

            // SEO & Extra
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'common_names' => ['nullable', 'array'],
            'problem_ids' => ['nullable', 'array'],
        ];
    }
}
