@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">Media Library</h2>
        <p class="text-muted mb-0" style="font-size:14px">Upload, manage, and inspect image assets across your application.</p>
    </div>
    <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload Files</button>
</div>

<!-- Search & Filter Card -->
<div class="card-custom mb-4">
    <form action="{{ route('admin.media.index') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-md-10">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by filename, title, or alt text...">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100 fw-bold"><i class="fa-solid fa-search me-1"></i> Search</button>
        </div>
    </form>
</div>

<!-- Media Grid -->
<div class="row g-3">
    @forelse($mediaItems as $media)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <div class="card-custom p-2 h-100 position-relative text-center mb-0">
                <div style="height:120px;overflow:hidden;border-radius:12px;background:#f8faf9" class="d-flex align-items-center justify-content-center mb-2">
                    @if(str_starts_with($media->mime_type, 'image/'))
                        <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        <i class="fa-regular fa-file-code fa-3x text-muted"></i>
                    @endif
                </div>
                <div class="text-truncate fw-bold small mb-1" title="{{ $media->original_name }}">{{ $media->original_name }}</div>
                <div class="text-muted" style="font-size:11px">{{ $media->formatted_size }}</div>

                <div class="d-flex justify-content-center gap-1 mt-2">
                    <button class="btn btn-sm btn-light border p-1 px-2 text-primary" onclick="navigator.clipboard.writeText('{{ $media->url }}'); alert('File URL copied to clipboard!');" title="Copy URL"><i class="fa-regular fa-copy"></i></button>
                    <button class="btn btn-sm btn-light border p-1 px-2 text-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $media->id }}" title="Edit Details"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this media file permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light border p-1 px-2 text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $media->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:20px">
                    <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">Edit Media Metadata</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Title</label>
                                <input type="text" name="title" value="{{ old('title', $media->title) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Alt Text (Accessibility & SEO)</label>
                                <input type="text" name="alt_text" value="{{ old('alt_text', $media->alt_text) }}" class="form-control">
                            </div>
                            <div class="text-muted small">
                                <div><strong>MIME Type:</strong> {{ $media->mime_type }}</div>
                                <div><strong>Dimensions:</strong> {{ $media->width && $media->height ? "{$media->width} x {$media->height} px" : 'N/A' }}</div>
                                <div><strong>File Size:</strong> {{ $media->formatted_size }}</div>
                                <div><strong>Uploaded:</strong> {{ $media->created_at->format('M d, Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success fw-bold">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-custom text-center py-5 text-muted">
                <i class="fa-regular fa-images fa-3x mb-3"></i>
                <h5>No media files found</h5>
                <p class="small mb-0">Upload image assets to start building your media library.</p>
            </div>
        </div>
    @endforelse
</div>

@if($mediaItems->hasPages())
    <div class="mt-4">
        {{ $mediaItems->links() }}
    </div>
@endif

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:20px">
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Upload Media Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Select Image File(s)</label>
                        <input type="file" name="files[]" class="form-control" multiple accept="image/jpeg,image/png,image/webp,image/gif" required>
                        <div class="form-text">Supported formats: JPG, PNG, WEBP, GIF (Max 10MB per file).</div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="fa-solid fa-upload me-1"></i> Start Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
