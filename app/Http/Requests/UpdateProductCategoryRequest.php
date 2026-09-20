<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $id = $this->route('product_category')?->id ?: $this->route('category')?->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:product_categories,slug,{$id}",
            'parent_id' => "nullable|exists:product_categories,id|different:id",
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'image_id' => 'nullable|exists:media,id',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
