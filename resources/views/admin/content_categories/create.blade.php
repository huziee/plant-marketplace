@extends('layouts.admin')

@section('title', 'Create Content Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Create Content Category</h2>
        <p class="text-muted small mb-0">Add a new category for grouping articles, guides, or news items.</p>
    </div>
    <a href="{{ route('admin.content-categories.index') }}" class="btn btn-outline-secondary" style="border-radius:12px"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card-custom">
    <form action="{{ route('admin.content-categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Indoor Gardening">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Slug (Auto-generated if left empty)</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="e.g. indoor-gardening">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Parent Category</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- None (Root Category) --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Applicable Type <span class="text-danger">*</span></label>
                <select name="type" class="form-select" required>
                    <option value="all" selected>All Types (Articles, Guides & News)</option>
                    <option value="article">Articles Only</option>
                    <option value="guide">Guides Only</option>
                    <option value="news">News Only</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Category Cover Image</label>
                <div class="border rounded-3 p-3 bg-light text-center mb-2" style="min-height: 140px; max-height: 180px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img id="catImgPreview" src="" alt="Preview" class="rounded w-100 h-100 object-fit-cover d-none">
                    <div id="catImgPlaceholder" class="text-muted small">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-success opacity-75"></i>
                        <div>Click below to upload category cover image</div>
                    </div>
                </div>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewCatImage(this)">
                @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Category Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief description of topics covered in this category..."></textarea>
            </div>

            <div class="col-md-12 mt-4 text-end">
                <button type="submit" class="btn btn-success px-4" style="border-radius:12px;font-weight:700">Save Category <i class="fa-solid fa-arrow-right ms-1"></i></button>
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
