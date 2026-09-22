@extends('layouts.admin')

@section('title', 'Edit Page - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Page: {{ $page->title }}</h1>
        <p class="text-muted small mb-0">Modify page content, publishing status, and SEO metadata.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-outline-success" style="border-radius:12px"><i class="fa-solid fa-eye me-1"></i> Preview Page</a>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary" style="border-radius:12px"><i class="fa-solid fa-arrow-left me-1"></i> Back to Pages</a>
    </div>
</div>

<form action="{{ route('admin.pages.update', $page) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-custom">
                <div class="mb-3">
                    <label class="form-label fw-bold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">URL Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" {{ $page->is_system ? 'readonly' : '' }}>
                    @if($page->is_system)
                        <div class="form-text text-muted"><i class="fa-solid fa-lock me-1"></i> Core system page slug is protected to preserve SEO routing.</div>
                    @endif
                </div>

                @if($page->is_system)
                    <div class="alert alert-info border-0 rounded-4 shadow-sm p-4 mb-3" style="background:#e0f2fe;color:#0369a1;">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-lock fa-2x"></i>
                            <div>
                                <strong class="d-block text-dark" style="font-size:1.05rem;">Core Static System Page (Protected)</strong>
                                <span class="small" style="line-height:1.5;">The content for this essential company/policy page is rendered using static Blade theme templates to preserve design integrity. Content editing from the admin panel is disabled. You can manage SEO Title, Meta Description, and Footer visibility below.</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label fw-bold">Page Content (HTML Supported) <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="20" required>{{ old('content', $page->content) }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-custom mb-4">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Publishing Settings</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published (Live)</option>
                        <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="show_in_footer" value="1" id="show_in_footer" {{ old('show_in_footer', $page->show_in_footer) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="show_in_footer">Show Link in Footer Navigation</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius:12px">
                    <i class="fa-solid fa-save me-1"></i> Save Changes
                </button>
            </div>

            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">SEO Metadata</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">SEO Title Tag</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="4">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
