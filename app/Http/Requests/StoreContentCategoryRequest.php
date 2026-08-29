<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isEditor();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_categories,slug',
            'parent_id' => 'nullable|exists:content_categories,id',
            'description' => 'nullable|string',
            'type' => 'required|in:article,guide,news,all',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
            'featured_image_id' => 'nullable|exists:media,id',
        ];
    }
}
