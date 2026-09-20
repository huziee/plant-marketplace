@extends('layouts.admin')

@section('title', 'Content Automation Settings')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <a href="{{ route('admin.content-automation.index') }}" class="text-decoration-none text-muted small fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> Back to Staging Candidates</a>
    <h2 class="fw-bold mb-1 mt-1" style="font-family:'Playfair Display',serif">Content Automation Settings & Topic Queue</h2>
    <p class="text-muted small mb-0">Configure content generation limits, system author defaults, OpenAI models, and rotation topics</p>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
@endif

<div class="row g-4">
  <!-- General Automation Settings -->
  <div class="col-lg-6">
    <div class="card card-custom">
      <h5 class="fw-bold mb-4 border-bottom pb-2"><i class="fa-solid fa-sliders text-success me-2"></i> Automation Configurations</h5>

      <form method="POST" action="{{ route('admin.content-automation.settings.update') }}">
        @csrf

        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" name="automation_enabled" id="automation_enabled" value="1" {{ app(\App\Services\SettingsService::class)->get('automation.enabled', true) ? 'checked' : '' }}>
          <label class="form-check-label fw-bold" for="automation_enabled">Enable Content Automation Master Suite</label>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="news_enabled" id="news_enabled" value="1" {{ app(\App\Services\SettingsService::class)->get('automation.news_enabled', true) ? 'checked' : '' }}>
              <label class="form-check-label small fw-bold" for="news_enabled">Enable GDELT News</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="articles_enabled" id="articles_enabled" value="1" {{ app(\App\Services\SettingsService::class)->get('automation.articles_enabled', true) ? 'checked' : '' }}>
              <label class="form-check-label small fw-bold" for="articles_enabled">Enable OpenAlex Articles</label>
            </div>
          </div>
        </div>

        <hr class="my-4">

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-bold small">News Per Day Limit</label>
            <input type="number" name="news_per_day" class="form-control rounded-3" value="{{ app(\App\Services\SettingsService::class)->get('automation.news_per_day', 1) }}" min="1" max="20" required>
            <small class="text-muted d-block">Max GDELT news candidates per day</small>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold small">Articles Per Day Limit</label>
            <input type="number" name="articles_per_day" class="form-control rounded-3" value="{{ app(\App\Services\SettingsService::class)->get('automation.articles_per_day', 1) }}" min="1" max="20" required>
            <small class="text-muted d-block">Max OpenAlex article candidates per day</small>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small">Default Public Author Identity</label>
          <select name="default_author_id" class="form-select rounded-3" required>
            @foreach($authors as $author)
              <option value="{{ $author->id }}" {{ app(\App\Services\SettingsService::class)->get('automation.default_author_id') == $author->id ? 'selected' : '' }}>
                {{ $author->name }} ({{ $author->email }}) &bull; Role: {{ strtoupper($author->role) }}
              </option>
            @endforeach
          </select>
          <small class="text-muted">Select user account to attribute all generated content to (Default: Plantaric Editorial Team)</small>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold small">OpenAI Writing Model</label>
          <select name="openai_model" class="form-select rounded-3" required>
            <option value="gpt-4o-mini" {{ app(\App\Services\SettingsService::class)->get('automation.openai_model', 'gpt-4o-mini') == 'gpt-4o-mini' ? 'selected' : '' }}>gpt-4o-mini (Fast & Recommended)</option>
            <option value="gpt-4o" {{ app(\App\Services\SettingsService::class)->get('automation.openai_model') == 'gpt-4o' ? 'selected' : '' }}>gpt-4o (High Quality)</option>
            <option value="gpt-3.5-turbo" {{ app(\App\Services\SettingsService::class)->get('automation.openai_model') == 'gpt-3.5-turbo' ? 'selected' : '' }}>gpt-3.5-turbo</option>
          </select>
        </div>

        <div class="p-3 bg-light rounded-3 border mb-4">
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="auto_publish" id="auto_publish" value="1" {{ app(\App\Services\SettingsService::class)->get('automation.auto_publish', false) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold text-danger" for="auto_publish">Auto-Publish Generated Posts</label>
          </div>
          <small class="text-muted d-block mt-1">If enabled, validated generated posts will immediately become <strong>Published</strong> instead of remaining in <strong>Draft</strong> state.</small>
        </div>

        <button type="submit" class="btn btn-dark rounded-3 w-100 py-2">
          <i class="fa-solid fa-floppy-disk me-1"></i> Save Settings
        </button>
      </form>
    </div>
  </div>

  <!-- Article Topic Rotation Queue -->
  <div class="col-lg-6">
    <div class="card card-custom mb-4">
      <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fa-solid fa-plus-circle text-primary me-2"></i> Add Article Topic to Queue</h5>
      <form method="POST" action="{{ route('admin.content-automation.topics.store') }}">
        @csrf
        <input type="hidden" name="content_type" value="article">
        
        <div class="mb-2">
          <label class="form-label small fw-bold mb-1">Topic Name</label>
          <input type="text" name="topic" class="form-control rounded-3" placeholder="e.g. Soil Health & Plant Growth" required>
        </div>
        <div class="row g-2 mb-2">
          <div class="col-md-7">
            <label class="form-label small fw-bold mb-1">OpenAlex Search Query</label>
            <input type="text" name="search_query" class="form-control rounded-3" placeholder="e.g. soil pH tomato growth" required>
          </div>
          <div class="col-md-5">
            <label class="form-label small fw-bold mb-1">Primary Keyword</label>
            <input type="text" name="primary_keyword" class="form-control rounded-3" placeholder="e.g. soil pH plant growth">
          </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-md-6">
            <label class="form-label small fw-bold mb-1">Priority (Higher = First)</label>
            <input type="number" name="priority" class="form-control rounded-3" value="5" min="0" max="100">
          </div>
          <div class="col-md-6 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 rounded-3"><i class="fa-solid fa-plus me-1"></i> Add Topic</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Active Topics List -->
    <div class="card card-custom p-0 overflow-hidden">
      <div class="p-3 border-bottom bg-light">
        <h6 class="fw-bold mb-0">Active Article Topics Queue ({{ $topics->count() }})</h6>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
          <thead class="table-light">
            <tr>
              <th>Topic</th>
              <th>Search Query</th>
              <th style="width:70px">Priority</th>
              <th style="width:60px" class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($topics as $t)
              <tr>
                <td class="fw-bold">{{ $t->topic }}</td>
                <td class="text-muted"><code>{{ $t->search_query }}</code></td>
                <td><span class="badge bg-secondary">{{ $t->priority }}</span></td>
                <td class="text-end">
                  <form method="POST" action="{{ route('admin.content-automation.topics.destroy', $t) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-outline-danger border-0" onclick="return confirm('Remove topic?')"><i class="fa-solid fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-4 text-muted">No active topics found in rotation.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
