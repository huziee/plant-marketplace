@extends('layouts.admin')

@section('title', 'Edit Plant Category')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.plant-categories.index') }}" class="text-decoration-none text-muted small fw-bold">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Categories
    </a>
    <h2 class="fw-bold mt-2" style="font-family:'Playfair Display',serif">Edit Category: {{ $plantCategory->name }}</h2>
</div>

<form action="{{ route('admin.plant-categories.update', $plantCategory->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Category Information</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $plantCategory->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Slug (URL identifier)</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $plantCategory->slug) }}">
                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Parent Category</label>
                    <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">None (Top Level Category)</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $plantCategory->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Short Description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $plantCategory->short_description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Full Description</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $plantCategory->description) }}</textarea>
                </div>
            </div>

            <div class="card card-custom">
                <h5 class="fw-bold mb-3">SEO Configuration</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold small">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $plantCategory->seo_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $plantCategory->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Thumbnail Image</h5>
                @if($plantCategory->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $plantCategory->image->file_path) }}" alt="{{ $plantCategory->name }}" class="img-thumbnail rounded" style="max-height: 150px; object-fit: cover;">
                    </div>
                @endif
                <div class="mb-3">
                    <label class="form-label fw-bold small">Upload New Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <div class="form-text text-muted small">JPG, PNG, WebP up to 4MB.</div>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Status & Options</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $plantCategory->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $plantCategory->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $plantCategory->sort_order) }}">
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $plantCategory->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="isFeatured">Featured on Homepage</label>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius:12px;background:var(--green-900)">
                    Update Category
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
