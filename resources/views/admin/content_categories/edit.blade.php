@extends('layouts.admin')

@section('title', "Edit Content Category: {$contentCategory->name}")

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Edit Content Category</h2>
        <p class="text-muted small mb-0">Modifying category <strong>{{ $contentCategory->name }}</strong></p>
    </div>
    <a href="{{ route('admin.content-categories.index') }}" class="btn btn-outline-secondary" style="border-radius:12px"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card-custom">
    <form action="{{ route('admin.content-categories.update', $contentCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $contentCategory->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @error
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $contentCategory->slug) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Parent Category</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- None (Root Category) --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $contentCategory->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Applicable Type <span class="text-danger">*</span></label>
                <select name="type" class="form-select" required>
                    <option value="all" {{ old('type', $contentCategory->type) === 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="article" {{ old('type', $contentCategory->type) === 'article' ? 'selected' : '' }}>Articles Only</option>
                    <option value="guide" {{ old('type', $contentCategory->type) === 'guide' ? 'selected' : '' }}>Guides Only</option>
                    <option value="news" {{ old('type', $contentCategory->type) === 'news' ? 'selected' : '' }}>News Only</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status', $contentCategory->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $contentCategory->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Category Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $contentCategory->description) }}</textarea>
            </div>

            <div class="col-md-12 mt-4 text-end">
                <button type="submit" class="btn btn-success px-4" style="border-radius:12px;font-weight:700">Update Category <i class="fa-solid fa-check ms-1"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection
