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
    <form action="{{ route('admin.content-categories.update', $contentCategory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $contentCategory->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <label class="form-label fw-bold">Category Cover Image</label>
                <div class="border rounded-3 p-3 bg-light text-center mb-2" style="min-height: 140px; max-height: 180px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    @if($contentCategory->featuredImage)
                        <img id="catImgPreview" src="{{ asset('storage/' . $contentCategory->featuredImage->file_path) }}" alt="Category Image" class="rounded w-100 h-100 object-fit-cover">
                        <div id="catImgPlaceholder" class="text-muted small d-none">
                            <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-success opacity-75"></i>
                            <div>Click below to upload category cover image</div>
                        </div>
                    @else
                        <img id="catImgPreview" src="" alt="Preview" class="rounded w-100 h-100 object-fit-cover d-none">
                        <div id="catImgPlaceholder" class="text-muted small">
                            <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-success opacity-75"></i>
                            <div>Click below to upload category cover image</div>
                        </div>
                    @endif
                </div>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewCatImage(this)">
                <div class="form-text text-muted small">Select a new image file to replace current cover image.</div>
                @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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

@push('scripts')
<script>
function previewCatImage(input) {
    const preview = document.getElementById('catImgPreview');
    const placeholder = document.getElementById('catImgPlaceholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
