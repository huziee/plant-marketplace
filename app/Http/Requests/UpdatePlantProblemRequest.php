<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlantProblemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $problem = $this->route('plant_problem');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('plant_problems')->ignore($problem->id)],
            'problem_type' => ['required', Rule::in(['disease', 'pest', 'watering', 'nutrient', 'environment', 'soil', 'physical_damage', 'unknown'])],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'severity' => ['required', Rule::in(['low', 'medium', 'high'])],
            'featured_image_id' => ['nullable', 'exists:media,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'is_featured' => ['nullable', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'symptoms' => ['nullable', 'array'],
            'causes' => ['nullable', 'array'],
            'treatments' => ['nullable', 'array'],
            'preventions' => ['nullable', 'array'],
        ];
    }
}
