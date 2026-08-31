@extends('layouts.admin')

@section('title', 'Create Custom Page - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-file-plus text-success me-2"></i>Create New Page</h1>
        <p class="text-muted small mb-0">Write custom pages with HTML content and SEO metadata.</p>
    </div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary" style="border-radius:12px"><i class="fa-solid fa-arrow-left me-1"></i> Back to Pages</a>
</div>

<form action="{{ route('admin.pages.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-custom">
                <div class="mb-3">
                    <label class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Sustainability Guidelines">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">URL Slug (Auto-generated if left empty)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="e.g. sustainability-guidelines">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Page Content (HTML Supported) <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="18" required placeholder="Write standard HTML page content (h2, h3, p, ul, blockquote, etc.)...">{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-custom mb-4">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Publishing Settings</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="published" selected>Published (Publicly live)</option>
                        <option value="draft">Draft (Hidden)</option>
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="show_in_footer" value="1" id="show_in_footer" checked>
                    <label class="form-check-label fw-bold" for="show_in_footer">Show Link in Footer Navigation</label>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius:12px;background:var(--green-900)">
                    <i class="fa-solid fa-save me-1"></i> Create & Publish Page
                </button>
            </div>

            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">SEO Metadata</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">SEO Title Tag</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Custom browser title...">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="4" placeholder="Brief summary for search engine snippets...">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
