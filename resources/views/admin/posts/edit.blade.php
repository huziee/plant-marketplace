@extends('layouts.admin')

@section('title', "Edit Post: {$post->title}")

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Edit Post</h2>
        <p class="text-muted small mb-0">Managing <strong>{{ $post->title }}</strong> ({{ $post->type->label() }})</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.posts.preview', $post->id) }}" target="_blank" class="btn btn-outline-info" style="border-radius:12px"><i class="fa-regular fa-eye me-1"></i> Preview</a>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary" style="border-radius:12px"><i class="fa-solid fa-arrow-left me-1"></i> Back to Content</a>
    </div>
</div>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Navigation Tabs & SEO Score Widget -->
    <div class="row g-3 align-items-center mb-4">
        <div class="col-md-8">
            <ul class="nav nav-pills gap-2 bg-white p-2 border rounded-4 shadow-sm" id="postTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-pane" type="button" role="tab"><i class="fa-solid fa-file-lines me-2"></i> Content</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="relations-tab" data-bs-toggle="tab" data-bs-target="#relations-pane" type="button" role="tab"><i class="fa-solid fa-diagram-project me-2"></i> Relationships</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-pane" type="button" role="tab"><i class="fa-regular fa-image me-2"></i> Media</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-pane" type="button" role="tab"><i class="fa-solid fa-magnifying-glass me-2"></i> SEO</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="publishing-tab" data-bs-toggle="tab" data-bs-target="#publishing-pane" type="button" role="tab"><i class="fa-solid fa-clock me-2"></i> Publishing</button>
                </li>
            </ul>
        </div>
        
        <div class="col-md-4">
            <div class="p-2 px-3 bg-white border rounded-4 shadow-sm d-flex align-items-center justify-content-between">
                <div>
                    <span class="small fw-bold text-muted d-block">SEO Editorial Checklist</span>
                    <strong class="text-success fs-5">{{ $post->seo_score['score'] }}/100 Score</strong>
                </div>
                <span class="badge bg-success-subtle text-success fs-6"><i class="fa-solid fa-chart-pie me-1"></i> Optimised</span>
            </div>
        </div>
    </div>

    <div class="tab-content" id="postTabsContent">
        <!-- Tab 1: Content -->
        <div class="tab-pane fade show active" id="content-pane" role="tabpanel">
            <div class="card-custom mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Post Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label fw-bold">Content Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="article" {{ old('type', $post->type->value) === 'article' ? 'selected' : '' }}>Article</option>
                                    <option value="guide" {{ old('type', $post->type->value) === 'guide' ? 'selected' : '' }}>Guide</option>
                                    <option value="news" {{ old('type', $post->type->value) === 'news' ? 'selected' : '' }}>News</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Category</label>
                                <select name="content_category_id" class="form-select">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('content_category_id', $post->content_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">URL Slug (Modifying creates 301 Redirect)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Post Excerpt / Summary</label>
                        <textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Main Content Body <span class="text-danger">*</span></label>
                        <textarea name="content" id="postContentEditor" class="form-control @error('content') is-invalid @enderror" rows="18">{{ old('content', $post->content) }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Internal Link Suggestions Box -->
            <div class="card-custom bg-light border-0">
                <h6 class="fw-bold mb-2 text-success"><i class="fa-solid fa-wand-magic-sparkles me-2"></i> Suggested Internal Link Anchors</h6>
                <p class="small text-muted mb-3">Copy and insert these internal URL links into your content to improve internal SEO structure:</p>

                <div class="d-flex flex-wrap gap-2">
                    @foreach($plants->take(4) as $sp)
                        <span class="badge bg-white text-dark border p-2"><i class="fa-solid fa-leaf text-success me-1"></i> Plant: <code>/plants/{{ $sp->slug }}</code></span>
                    @endforeach
                    @foreach($problems->take(3) as $sprob)
                        <span class="badge bg-white text-dark border p-2"><i class="fa-solid fa-user-doctor text-warning me-1"></i> Problem: <code>/plant-problems/{{ $sprob->slug }}</code></span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tab 2: Relationships -->
        <div class="tab-pane fade" id="relations-pane" role="tabpanel">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Connect Content to Plantaric Taxonomy</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-leaf text-success me-1"></i> Related Plants</label>
                        <select name="plants[]" class="form-select" multiple style="height:140px">
                            @foreach($plants as $p)
                                <option value="{{ $p->id }}" {{ $post->plants->contains($p->id) ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-user-doctor text-warning me-1"></i> Related Plant Problems</label>
                        <select name="problems[]" class="form-select" multiple style="height:140px">
                            @foreach($problems as $prob)
                                <option value="{{ $prob->id }}" {{ $post->problems->contains($prob->id) ? 'selected' : '' }}>{{ $prob->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-tags text-primary me-1"></i> Content Tags</label>
                        <select name="tags[]" class="form-select" multiple style="height:120px">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-link text-info me-1"></i> Related Articles/Posts</label>
                        <select name="related_posts[]" class="form-select" multiple style="height:120px">
                            @foreach($posts as $relP)
                                <option value="{{ $relP->id }}" {{ $post->relatedPosts->contains($relP->id) ? 'selected' : '' }}>{{ $relP->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: Media -->
        <div class="tab-pane fade" id="media-pane" role="tabpanel">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Featured Media Assets</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Featured Header Image</label>
                        <div class="border rounded-3 p-3 bg-light text-center mb-2" style="min-height: 160px; max-height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            @if($post->featuredImage)
                                <img id="featuredImgPreview" src="{{ asset('storage/' . $post->featuredImage->file_path) }}" alt="Featured Image" class="rounded w-100 h-100 object-fit-cover">
                                <div id="featuredImgPlaceholder" class="text-muted small d-none">
                                    <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-success opacity-75"></i>
                                    <div>Click below to select featured image</div>
                                </div>
                            @else
                                <img id="featuredImgPreview" src="" alt="Preview" class="rounded w-100 h-100 object-fit-cover d-none">
                                <div id="featuredImgPlaceholder" class="text-muted small">
                                    <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-success opacity-75"></i>
                                    <div>Click below to select featured image</div>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*" onchange="previewMediaImage(this, 'featuredImgPreview', 'featuredImgPlaceholder')">
                        <div class="form-text text-muted small">Select a new file to replace existing featured header image.</div>
                        @error('featured_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Open Graph Share Image (Optional)</label>
                        <div class="border rounded-3 p-3 bg-light text-center mb-2" style="min-height: 160px; max-height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            @if($post->ogImage)
                                <img id="ogImgPreview" src="{{ asset('storage/' . $post->ogImage->file_path) }}" alt="OG Image" class="rounded w-100 h-100 object-fit-cover">
                                <div id="ogImgPlaceholder" class="text-muted small d-none">
                                    <i class="fa-solid fa-share-nodes fa-2x mb-2 text-info opacity-75"></i>
                                    <div>Click below to select OG image</div>
                                </div>
                            @else
                                <img id="ogImgPreview" src="" alt="Preview" class="rounded w-100 h-100 object-fit-cover d-none">
                                <div id="ogImgPlaceholder" class="text-muted small">
                                    <i class="fa-solid fa-share-nodes fa-2x mb-2 text-info opacity-75"></i>
                                    <div>Click below to select OG social share image</div>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="og_image" class="form-control @error('og_image') is-invalid @enderror" accept="image/*" onchange="previewMediaImage(this, 'ogImgPreview', 'ogImgPlaceholder')">
                        <div class="form-text text-muted small">Recommended size 1200x630px for Facebook/Twitter cards.</div>
                        @error('og_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: SEO -->
        <div class="tab-pane fade" id="seo-pane" role="tabpanel">
            <div class="card-custom mb-4">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Search Engine Optimization Checklist</h5>
                
                <div class="row g-3 mb-4">
                    @foreach($post->seo_score['checks'] as $label => $passed)
                        <div class="col-md-4">
                            <div class="p-2 border rounded-3 d-flex align-items-center gap-2 bg-light">
                                <i class="fa-solid {{ $passed ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger' }}"></i>
                                <span class="small fw-bold">{{ $label }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">SEO Title Tag</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $post->seo_title) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Focus Target Keyword</label>
                        <input type="text" name="focus_keyword" class="form-control" value="{{ old('focus_keyword', $post->focus_keyword) }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Canonical URL Override</label>
                        <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url', $post->canonical_url) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Search Indexing</label>
                        <select name="robots_index" class="form-select">
                            <option value="1" {{ $post->robots_index ? 'selected' : '' }}>Index (Allow Google search indexing)</option>
                            <option value="0" {{ !$post->robots_index ? 'selected' : '' }}>NoIndex (Hide from Google search)</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Link Following</label>
                        <select name="robots_follow" class="form-select">
                            <option value="1" {{ $post->robots_follow ? 'selected' : '' }}>Follow (Follow internal links)</option>
                            <option value="0" {{ !$post->robots_follow ? 'selected' : '' }}>NoFollow (Do not follow links)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 5: Publishing -->
        <div class="tab-pane fade" id="publishing-pane" role="tabpanel">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Publishing Workflow & Status</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Publication Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ old('status', $post->status->value) === 'draft' ? 'selected' : '' }}>Draft (Private draft)</option>
                            <option value="review" {{ old('status', $post->status->value) === 'review' ? 'selected' : '' }}>Review (Submit for Editor review)</option>
                            <option value="scheduled" {{ old('status', $post->status->value) === 'scheduled' ? 'selected' : '' }}>Scheduled (Publish at future date)</option>
                            <option value="published" {{ old('status', $post->status->value) === 'published' ? 'selected' : '' }}>Published (Make publicly live)</option>
                            <option value="archived" {{ old('status', $post->status->value) === 'archived' ? 'selected' : '' }}>Archived (Unlisted)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Author Account</label>
                        <select name="author_id" class="form-select" required>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', $post->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }} ({{ ucfirst($author->role) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Scheduled Release Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at', $post->scheduled_at ? $post->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ $post->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_featured">Feature on Homepage</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="is_editor_pick" value="1" id="is_editor_pick" {{ $post->is_editor_pick ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_editor_pick">Mark as Editor's Pick</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Bar -->
    <div class="p-4 bg-white border rounded-4 shadow-sm d-flex justify-content-between align-items-center mt-4 mb-5">
        <span class="text-muted small"><i class="fa-solid fa-clock-rotate-left text-success me-1"></i> Content updated at {{ $post->updated_at->format('M d, Y H:i') }}</span>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4" style="border-radius:12px;font-weight:700">Update Content <i class="fa-solid fa-check ms-1"></i></button>
        </div>
    </div>
</form>

@push('admin_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '#postContentEditor',
        height: 520,
        plugins: 'image link media table code lists advlist visualblocks wordcount fullscreen preview autolink help',
        toolbar: 'undo redo | blocks | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | numlist bullist | image media table link | code fullscreen preview',
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: function (blobInfo, progress) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route("admin.posts.upload-image") }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }
                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed. Transport error code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            });
        },
        style_formats: [
            { title: 'Align Left (Text Wraps Right)', selector: 'img', styles: { 'float': 'left', 'margin': '0 24px 20px 0', 'max-width': '48%' } },
            { title: 'Align Right (Text Wraps Left)', selector: 'img', styles: { 'float': 'right', 'margin': '0 0 20px 24px', 'max-width': '48%' } },
            { title: 'Center Full Width', selector: 'img', styles: { 'display': 'block', 'margin': '0 auto 20px auto', 'max-width': '100%' } },
        ],
        content_style: 'body { font-family: "DM Sans", sans-serif; font-size: 16px; color: #222; line-height: 1.7; } img { max-width: 100%; height: auto; border-radius: 8px; } img[style*="float: left"] { float: left; margin: 0 24px 20px 0; max-width: 48%; } img[style*="float: right"] { float: right; margin: 0 0 20px 24px; max-width: 48%; }'
    });
});

function previewMediaImage(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);
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
