@extends('layouts.admin')

@section('title', 'Create Plant Category')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.plant-categories.index') }}" class="text-decoration-none text-muted small fw-bold">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Categories
    </a>
    <h2 class="fw-bold mt-2" style="font-family:'Playfair Display',serif">Create Plant Category</h2>
</div>

<form action="{{ route('admin.plant-categories.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Category Information</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Slug (URL identifier)</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Parent Category</label>
                    <select name="parent_id" class="form-select">
                        <option value="">None (Top Level Category)</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Full Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="card card-custom">
                <h5 class="fw-bold mb-3">SEO Configuration</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold small">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Status & Options</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="isFeatured">Featured on Homepage</label>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius:12px;background:var(--green-900)">
                    Save Category
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
