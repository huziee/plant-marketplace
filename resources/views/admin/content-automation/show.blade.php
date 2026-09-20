@extends('layouts.admin')

@section('title', 'Candidate Inspection #' . $candidate->id)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <a href="{{ route('admin.content-automation.index') }}" class="text-decoration-none text-muted small fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back to Staging Candidates</a>
    <h2 class="fw-bold mb-1 mt-1" style="font-family:'Playfair Display',serif">Candidate #{{ $candidate->id }} Inspection</h2>
    <p class="text-muted small mb-0">Private Research Context & Source Provenance (Internal Admin Access Only)</p>
  </div>
  <div class="d-flex gap-2">
    @if(in_array($candidate->status, ['discovered', 'ready']))
      <form method="POST" action="{{ route('admin.content-automation.generate', $candidate) }}">
        @csrf
        <button type="submit" class="btn btn-success rounded-3 px-4">
          <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Generate OpenAI Post
        </button>
      </form>
    @elseif($candidate->status === 'failed')
      <form method="POST" action="{{ route('admin.content-automation.retry', $candidate) }}">
        @csrf
        <button type="submit" class="btn btn-warning rounded-3 px-4">
          <i class="fa-solid fa-rotate-right me-1"></i> Retry Generation
        </button>
      </form>
    @endif
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

@if($candidate->failure_reason)
  <div class="alert alert-danger rounded-3 mb-4">
    <h6 class="fw-bold"><i class="fa-solid fa-circle-xmark me-2"></i> Generation Failure Reason</h6>
    <p class="mb-0 small text-break">{{ $candidate->failure_reason }}</p>
  </div>
@endif

<div class="row g-4">
  <!-- Left Column: Details & Research Context -->
  <div class="col-lg-7">
    <div class="card card-custom mb-4">
      <h5 class="fw-bold mb-3 border-bottom pb-2">Candidate Information</h5>
      <div class="row g-3 small">
        <div class="col-md-6">
          <span class="text-muted d-block">Content Type</span>
          <span class="fw-bold text-uppercase badge bg-dark mt-1">{{ $candidate->content_type }}</span>
        </div>
        <div class="col-md-6">
          <span class="text-muted d-block">Discovery Source</span>
          <span class="fw-bold text-uppercase badge bg-light text-dark border mt-1">{{ $candidate->source_type }}</span>
        </div>
        <div class="col-md-6">
          <span class="text-muted d-block">Topic Category</span>
          <span class="fw-bold text-dark">{{ $candidate->topic ?: 'N/A' }}</span>
        </div>
        <div class="col-md-6">
          <span class="text-muted d-block">Status</span>
          <span class="fw-bold text-uppercase badge bg-info text-dark mt-1">{{ $candidate->status }}</span>
        </div>
        <div class="col-12">
          <span class="text-muted d-block">Suggested Title</span>
          <h6 class="fw-bold text-dark mt-1">{{ $candidate->suggested_title ?: 'N/A' }}</h6>
        </div>
        <div class="col-12">
          <span class="text-muted d-block">Fingerprint Hash (Unique)</span>
          <code class="small text-muted bg-light p-1 rounded d-block text-break">{{ $candidate->fingerprint }}</code>
        </div>
      </div>
    </div>

    <!-- Research Context JSON -->
    <div class="card card-custom">
      <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fa-solid fa-microscope text-primary me-2"></i> Structured Factual Research Context</h5>
      @if($candidate->research_context)
        <pre class="bg-dark text-light p-3 rounded-3 small mb-0 overflow-auto" style="max-height:400px"><code>{{ json_encode($candidate->research_context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
      @else
        <p class="text-muted small mb-0">Context not built yet. Click generate to construct context automatically.</p>
      @endif
    </div>
  </div>

  <!-- Right Column: Private Sources & Created Post -->
  <div class="col-lg-5">
    @if($candidate->post)
      <div class="card card-custom bg-success-subtle border-success mb-4">
        <h5 class="fw-bold text-success mb-2"><i class="fa-solid fa-circle-check me-2"></i> Generated Post Created</h5>
        <h6 class="fw-bold text-dark mb-2">{{ $candidate->post->title }}</h6>
        <p class="small text-muted mb-3">Status: <span class="badge bg-secondary text-uppercase">{{ $candidate->post->status->value }}</span> &bull; Author: {{ $candidate->post->author?->name }}</p>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.posts.edit', $candidate->post->id) }}" class="btn btn-sm btn-success rounded-3 px-3">
            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Post
          </a>
          @if($candidate->post->status->value === 'published')
            <a href="{{ $candidate->post->public_url }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-3 px-3">
              <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Public View
            </a>
          @endif
        </div>
      </div>
    @endif

    <div class="card card-custom">
      <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fa-solid fa-shield-halved me-2 text-danger"></i> Private Research Sources (Admin Only)</h5>
      <p class="text-muted small mb-3">The sources below are kept privately for editorial verification and provenance. They are <strong>NOT</strong> displayed on the public frontend.</p>

      <div class="vstack gap-3">
        @forelse($candidate->researchSources as $source)
          <div class="p-3 bg-light rounded-3 border">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <span class="badge bg-dark text-uppercase small">{{ $source->provider }}</span>
              <small class="text-muted">{{ $source->published_at?->format('Y-m-d') }}</small>
            </div>
            <h6 class="fw-bold mb-1 text-dark">{{ $source->source_title }}</h6>
            <span class="small text-muted d-block mb-2">{{ $source->source_domain }}</span>
            <a href="{{ $source->source_url }}" target="_blank" class="btn btn-xs btn-outline-primary rounded-2 text-decoration-none">
              <i class="fa-solid fa-external-link me-1"></i> Visit Source Link
            </a>
          </div>
        @empty
          <p class="text-muted small mb-0">No private research sources attached.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection
