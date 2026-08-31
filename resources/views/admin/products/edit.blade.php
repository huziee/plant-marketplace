@extends('layouts.admin')

@section('title', 'Edit Product - Plantaric Admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Products
        </a>
        <h1 class="h3 mb-0 text-gray-800 mt-2">Edit Product: {{ $product->name }}</h1>
    </div>
    <a href="{{ route('frontend.shop.product', $product->slug) }}" target="_blank" class="btn btn-outline-success">
        <i class="fa-solid fa-external-link me-1"></i> Preview on Storefront
    </a>
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white font-weight-bold">Basic Product Info</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}" required>
                            @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea name="description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white font-weight-bold">Pricing & Stock</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price (Rs.) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Compare Price (Rs.)</label>
                            <input type="number" step="0.01" name="compare_price" class="form-control" value="{{ old('compare_price', $product->compare_price) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cost Price (Rs.)</label>
                            <input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price', $product->cost_price) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Low Stock Threshold</label>
                            <input type="number" name="low_stock_threshold" class="form-control" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white font-weight-bold">Organization & Status</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="published" {{ old('status', $product->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ old('status', $product->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Category <span class="text-danger">*</span></label>
                        <select name="product_category_id" class="form-select @error('product_category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('product_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Type</label>
                        <select name="product_type" class="form-select">
                            @foreach($productTypes as $type)
                                <option value="{{ $type->value }}" {{ old('product_type', $product->product_type->value) === $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link to Plant Encyclopedia Record</label>
                        <select name="plant_id" class="form-select">
                            <option value="">None (Not a plant or unlinked)</option>
                            @foreach($plants as $p)
                                <option value="{{ $p->id }}" {{ old('plant_id', $product->plant_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->botanical_name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured Product</label>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_new" value="1" id="is_new" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_new">Badge as New Arrival</label>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="is_best_seller" value="1" id="is_best_seller" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_best_seller">Badge as Best Seller</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-save me-1"></i> Update Product</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
