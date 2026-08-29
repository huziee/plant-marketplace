<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:100|unique:products,sku',
            'product_category_id' => 'required|exists:product_categories,id',
            'plant_id' => 'nullable|exists:plants,id',
            'product_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'status' => 'required|string|in:draft,published,archived',
            'featured_image_id' => 'nullable|exists:media,id',
            'is_featured' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_best_seller' => 'nullable|boolean',
        ];
    }
}
