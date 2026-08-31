@extends('layouts.admin')

@section('title', 'Create Content Post')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Create New Content</h2>
        <p class="text-muted small mb-0">Write articles, plant guides, or news items with SEO metadata and botanical links.</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary" style="border-radius:12px"><i class="fa-solid fa-arrow-left me-1"></i> Back to Content</a>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST">
    @csrf

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-4 gap-2 bg-white p-2 border rounded-4 shadow-sm" id="postTabs" role="tablist">
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

    <div class="tab-content" id="postTabsContent">
        <!-- Tab 1: Content -->
        <div class="tab-pane fade show active" id="content-pane" role="tabpanel">
            <div class="card-custom">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Post Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Best Indoor Plants for Beginners">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label fw-bold">Content Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="article" {{ old('type', request('type')) === 'article' ? 'selected' : '' }}>Article</option>
                                    <option value="guide" {{ old('type', request('type')) === 'guide' ? 'selected' : '' }}>Guide</option>
                                    <option value="news" {{ old('type', request('type')) === 'news' ? 'selected' : '' }}>News</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Category</label>
                                <select name="content_category_id" class="form-select">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('content_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">URL Slug (Auto-generated if left empty)</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="e.g. best-indoor-plants-for-beginners">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Post Excerpt / Summary</label>
                        <textarea name="excerpt" class="form-control" rows="3" placeholder="Brief summary of article content (150-250 characters)...">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Main Content Body (HTML Supported) <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="16" required placeholder="Write your post content using standard HTML (h2, h3, p, ul, blockquote, etc.)...">{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
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
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Hold Ctrl/Cmd to select multiple plants linked to this guide/article.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-user-doctor text-warning me-1"></i> Related Plant Problems</label>
                        <select name="problems[]" class="form-select" multiple style="height:140px">
                            @foreach($problems as $prob)
                                <option value="{{ $prob->id }}">{{ $prob->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Link plant diseases or symptoms treated in this post.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-tags text-primary me-1"></i> Content Tags</label>
                        <select name="tags[]" class="form-select" multiple style="height:120px">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold"><i class="fa-solid fa-link text-info me-1"></i> Related Articles/Posts</label>
                        <select name="related_posts[]" class="form-select" multiple style="height:120px">
                            @foreach($posts as $relP)
                                <option value="{{ $relP->id }}">{{ $relP->title }}</option>
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
                        <select name="featured_image_id" class="form-select">
                            <option value="">-- None --</option>
                            @foreach($mediaFiles as $media)
                                <option value="{{ $media->id }}">{{ $media->file_name }} ({{ $media->alt_text ?: 'No ALT' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Open Graph Share Image</label>
                        <select name="og_image_id" class="form-select">
                            <option value="">-- Same as Featured Image --</option>
                            @foreach($mediaFiles as $media)
                                <option value="{{ $media->id }}">{{ $media->file_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 4: SEO -->
        <div class="tab-pane fade" id="seo-pane" role="tabpanel">
            <div class="card-custom">
                <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Search Engine Optimization</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">SEO Title Tag</label>
                        <input type="text" name="seo_title" class="form-control" placeholder="Target ~50-60 characters">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Focus Target Keyword</label>
                        <input type="text" name="focus_keyword" class="form-control" placeholder="e.g. Monstera Yellow Leaves">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3" placeholder="Target ~140-160 characters summary for Google search snippet..."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Canonical URL Override</label>
                        <input type="url" name="canonical_url" class="form-control" placeholder="Leave empty for default canonical URL">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Search Indexing</label>
                        <select name="robots_index" class="form-select">
                            <option value="1" selected>Index (Allow Google search indexing)</option>
                            <option value="0">NoIndex (Hide from Google search)</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Link Following</label>
                        <select name="robots_follow" class="form-select">
                            <option value="1" selected>Follow (Follow internal links)</option>
                            <option value="0">NoFollow (Do not follow links)</option>
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
                            <option value="draft" selected>Draft (Private draft)</option>
                            <option value="review">Review (Submit for Editor review)</option>
                            <option value="scheduled">Scheduled (Publish at future date)</option>
                            <option value="published">Published (Make publicly live)</option>
                            <option value="archived">Archived (Unlisted)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Author Account</label>
                        <select name="author_id" class="form-select" required>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id', auth()->id()) == $author->id ? 'selected' : '' }}>{{ $author->name }} ({{ ucfirst($author->role) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Scheduled Release Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}">
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured">
                            <label class="form-check-label fw-bold" for="is_featured">Feature on Homepage</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="is_editor_pick" value="1" id="is_editor_pick">
                            <label class="form-check-label fw-bold" for="is_editor_pick">Mark as Editor's Pick</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Bar -->
    <div class="p-4 bg-white border rounded-4 shadow-sm d-flex justify-content-between align-items-center mt-4 mb-5">
        <span class="text-muted small"><i class="fa-solid fa-shield-halved text-success me-1"></i> Content will be sanitized safely before saving.</span>
        <div class="d-flex gap-2">
            <button type="submit" name="status" value="draft" class="btn btn-outline-secondary" style="border-radius:12px">Save Draft</button>
            <button type="submit" class="btn btn-success px-4" style="border-radius:12px;font-weight:700">Save & Save Content <i class="fa-solid fa-arrow-right ms-1"></i></button>
        </div>
    </div>
</form>
@endsection
