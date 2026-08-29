@extends('layouts.admin')

@section('title', 'Content Management & Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Content & Publishing</h2>
        <p class="text-muted small mb-0">Manage articles, plant guides, news posts, SEO metadata, and publishing workflows.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.posts.create') }}?type=article" class="btn btn-sm btn-success" style="border-radius:12px"><i class="fa-solid fa-plus me-1"></i> New Article</a>
        <a href="{{ route('admin.posts.create') }}?type=guide" class="btn btn-sm btn-outline-success" style="border-radius:12px"><i class="fa-solid fa-book-open me-1"></i> New Guide</a>
        <a href="{{ route('admin.posts.create') }}?type=news" class="btn btn-sm btn-outline-dark" style="border-radius:12px"><i class="fa-regular fa-newspaper me-1"></i> New News</a>
    </div>
</div>

<!-- Filters -->
<div class="card-custom mb-4">
    <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search title or slug..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="article" {{ request('type') === 'article' ? 'selected' : '' }}>Articles</option>
                <option value="guide" {{ request('type') === 'guide' ? 'selected' : '' }}>Guides</option>
                <option value="news" {{ request('type') === 'news' ? 'selected' : '' }}>News</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>In Review</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-dark w-100" style="border-radius:10px">Filter</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary" style="border-radius:10px">Reset</a>
        </div>
    </form>
</div>

<!-- Posts Table -->
<div class="card-custom p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Title & Details</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Published Date</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($post->featuredImage)
                                    <img src="{{ asset('storage/' . $post->featuredImage->file_path) }}" class="rounded-3" style="width:48px;height:48px;object-fit:cover">
                                @else
                                    <div class="rounded-3 bg-light d-grid place-items-center text-muted" style="width:48px;height:48px"><i class="fa-regular fa-newspaper"></i></div>
                                @endif
                                <div>
                                    <strong class="d-block text-dark">{{ $post->title }}</strong>
                                    <span class="small text-muted">/{{ $post->type->routePrefix() }}/{{ $post->slug }}</span>
                                    @if($post->is_featured)
                                        <span class="badge bg-warning text-dark ms-1">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-dark-subtle text-dark text-capitalize">{{ $post->type->value }}</span></td>
                        <td>{{ $post->category?->name ?: 'Uncategorized' }}</td>
                        <td>{{ $post->author?->name }}</td>
                        <td>
                            <span class="badge {{ $post->status->badgeClass() }}">{{ $post->status->label() }}</span>
                        </td>
                        <td class="fw-bold">{{ number_format($post->views) }}</td>
                        <td class="small text-muted">
                            {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not Published' }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.posts.preview', $post->id) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Preview"><i class="fa-regular fa-eye"></i></a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.posts.duplicate', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="Duplicate"><i class="fa-regular fa-copy"></i></button>
                                </form>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">No posts found matching filter criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
        <div class="p-3 border-top">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
