<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isEditor();
    }

    public function rules(): array
    {
        $catId = $this->route('content_category') ? $this->route('content_category')->id : null;

        return [
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('content_categories', 'slug')->ignore($catId)],
            'parent_id' => ['nullable', 'exists:content_categories,id', Rule::notIn([$catId])],
            'description' => 'nullable|string',
            'type' => 'required|in:article,guide,news,all',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
            'featured_image_id' => 'nullable|exists:media,id',
        ];
    }
}
