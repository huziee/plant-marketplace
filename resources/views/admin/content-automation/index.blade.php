@extends('layouts.admin')

@section('title', 'Content Automation Staging')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Content Automation Engine</h2>
    <p class="text-muted small mb-0">Automated candidate discovery & AI generation (GDELT News & OpenAlex Articles)</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.content-automation.settings') }}" class="btn btn-outline-dark rounded-3 px-3">
      <i class="fa-solid fa-gear me-1"></i> Settings & Topics
    </a>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-success rounded-3 px-3" style="background:var(--green-900);border-color:var(--green-900)">
      <i class="fa-regular fa-newspaper me-1"></i> View Posts Table
    </a>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
    <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<!-- Metrics Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-2">
    <div class="card card-custom p-3 mb-0 text-center">
      <span class="text-muted small fw-bold text-uppercase">Total Candidates</span>
      <h3 class="fw-bold mb-0 mt-1" style="color:var(--green-950)">{{ number_format($metrics['total']) }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card card-custom p-3 mb-0 text-center">
      <span class="text-muted small fw-bold text-uppercase">Discovered</span>
      <h3 class="fw-bold mb-0 mt-1 text-primary">{{ number_format($metrics['discovered']) }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card card-custom p-3 mb-0 text-center">
      <span class="text-muted small fw-bold text-uppercase">Ready</span>
      <h3 class="fw-bold mb-0 mt-1 text-info">{{ number_format($metrics['ready']) }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card card-custom p-3 mb-0 text-center">
      <span class="text-muted small fw-bold text-uppercase">Generated</span>
      <h3 class="fw-bold mb-0 mt-1 text-success">{{ number_format($metrics['generated']) }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card card-custom p-3 mb-0 text-center">
      <span class="text-muted small fw-bold text-uppercase">Failed</span>
      <h3 class="fw-bold mb-0 mt-1 text-danger">{{ number_format($metrics['failed']) }}</h3>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card card-custom p-3 mb-0 text-center">
      <span class="text-muted small fw-bold text-uppercase">Rejected</span>
      <h3 class="fw-bold mb-0 mt-1 text-secondary">{{ number_format($metrics['rejected']) }}</h3>
    </div>
  </div>
</div>

<!-- Filters -->
<div class="card card-custom p-3 mb-4">
  <form method="GET" action="{{ route('admin.content-automation.index') }}" class="row g-2 align-items-center">
    <div class="col-md-3">
      <input type="text" name="search" class="form-control rounded-3" placeholder="Search title, topic or fingerprint..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
      <select name="type" class="form-select rounded-3">
        <option value="">All Content Types</option>
        <option value="article" {{ request('type') == 'article' ? 'selected' : '' }}>Articles (OpenAlex)</option>
        <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>News (GDELT)</option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="status" class="form-select rounded-3">
        <option value="">All Statuses</option>
        <option value="discovered" {{ request('status') == 'discovered' ? 'selected' : '' }}>Discovered</option>
        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready for Generation</option>
        <option value="generating" {{ request('status') == 'generating' ? 'selected' : '' }}>Generating</option>
        <option value="generated" {{ request('status') == 'generated' ? 'selected' : '' }}>Generated (Post Created)</option>
        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-dark w-100 rounded-3"><i class="fa-solid fa-filter me-1"></i> Filter</button>
    </div>
    <div class="col-md-2">
      <a href="{{ route('admin.content-automation.index') }}" class="btn btn-outline-secondary w-100 rounded-3">Reset</a>
    </div>
  </form>
</div>

<!-- Table -->
<div class="card card-custom p-0 overflow-hidden">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:70px">ID</th>
          <th style="width:100px">Type</th>
          <th>Suggested Title / Topic</th>
          <th style="width:120px">Source</th>
          <th style="width:130px">Status</th>
          <th style="width:130px">Post Link</th>
          <th style="width:150px">Discovered</th>
          <th style="width:200px" class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($candidates as $candidate)
          <tr>
            <td class="fw-bold text-muted">#{{ $candidate->id }}</td>
            <td>
              @if($candidate->content_type === 'news')
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="fa-regular fa-newspaper me-1"></i> News</span>
              @else
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"><i class="fa-solid fa-book-open me-1"></i> Article</span>
              @endif
            </td>
            <td>
              <div class="fw-bold text-dark">{{ Str::limit($candidate->suggested_title ?: $candidate->topic, 65) }}</div>
              <small class="text-muted"><i class="fa-solid fa-tag me-1"></i> {{ $candidate->topic ?: 'General' }}</small>
            </td>
            <td>
              <span class="badge bg-light text-dark border text-uppercase">{{ $candidate->source_type }}</span>
            </td>
            <td>
              @if($candidate->status === 'discovered')
                <span class="badge bg-secondary">Discovered</span>
              @elseif($candidate->status === 'ready')
                <span class="badge bg-info text-dark">Ready</span>
              @elseif($candidate->status === 'generating')
                <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i> Generating</span>
              @elseif(in_array($candidate->status, ['generated', 'published']))
                <span class="badge bg-success">Generated</span>
              @elseif($candidate->status === 'failed')
                <span class="badge bg-danger" title="{{ $candidate->failure_reason }}">Failed</span>
              @elseif($candidate->status === 'rejected')
                <span class="badge bg-dark">Rejected</span>
              @endif
            </td>
            <td>
              @if($candidate->post)
                <a href="{{ route('admin.posts.edit', $candidate->post_id) }}" class="btn btn-sm btn-outline-success rounded-3">
                  <i class="fa-regular fa-pen-to-square me-1"></i> Edit Post
                </a>
              @else
                <span class="text-muted small">—</span>
              @endif
            </td>
            <td class="small text-muted">
              {{ $candidate->created_at->format('M d, Y H:i') }}
            </td>
            <td class="text-end">
              <div class="d-flex align-items-center justify-content-end gap-1">
                <a href="{{ route('admin.content-automation.show', $candidate) }}" class="btn btn-sm btn-light border rounded-3" title="Inspect Research">
                  <i class="fa-solid fa-eye text-secondary"></i>
                </a>

                @if(in_array($candidate->status, ['discovered', 'ready']))
                  <form method="POST" action="{{ route('admin.content-automation.generate', $candidate) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success rounded-3" title="Generate OpenAI Draft">
                      <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Generate
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.content-automation.reject', $candidate) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Reject candidate">
                      <i class="fa-solid fa-xmark"></i>
                    </button>
                  </form>
                @elseif($candidate->status === 'failed')
                  <form method="POST" action="{{ route('admin.content-automation.retry', $candidate) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning rounded-3" title="Retry Generation">
                      <i class="fa-solid fa-rotate-right me-1"></i> Retry
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">
              <i class="fa-solid fa-robot fa-2x mb-3 d-block"></i>
              No content candidates found. Run artisan command <code>php artisan content:run</code> to discover candidates.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($candidates->hasPages())
    <div class="p-3 border-top">
      {{ $candidates->links() }}
    </div>
  @endif
</div>
@endsection
