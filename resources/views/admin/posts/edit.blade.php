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

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
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
                        <label class="form-label fw-bold">Main Content Body (HTML Supported) <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="18" required>{{ old('content', $post->content) }}</textarea>
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
                        <select name="featured_image_id" class="form-select">
                            <option value="">-- None --</option>
                            @foreach($mediaFiles as $media)
                                <option value="{{ $media->id }}" {{ old('featured_image_id', $post->featured_image_id) == $media->id ? 'selected' : '' }}>{{ $media->file_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Open Graph Share Image</label>
                        <select name="og_image_id" class="form-select">
                            <option value="">-- Same as Featured Image --</option>
                            @foreach($mediaFiles as $media)
                                <option value="{{ $media->id }}" {{ old('og_image_id', $post->og_image_id) == $media->id ? 'selected' : '' }}>{{ $media->file_name }}</option>
                            @endforeach
                        </select>
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
@endsection
