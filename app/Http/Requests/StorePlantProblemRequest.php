<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlantProblemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('plant_problems')],
            'problem_type' => ['required', Rule::in(['disease', 'pest', 'watering', 'nutrient', 'environment', 'soil', 'physical_damage', 'unknown'])],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'severity' => ['required', Rule::in(['low', 'medium', 'high'])],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
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
