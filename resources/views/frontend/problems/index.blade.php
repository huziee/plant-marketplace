@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Hero Header -->
<section class="hero" style="padding-bottom:10px">
  <div class="container">
    <div class="hero-grid" style="min-height:380px;background:linear-gradient(135deg, var(--green-950), var(--green-900))">
      <div class="hero-copy" style="padding:48px 42px">
        <span class="eyebrow" style="background:rgba(255,255,255,.1);color:#dff2ca"><i class="fa-solid fa-user-doctor"></i> Plant Doctor Symptom Solver</span>
        <h1 style="font-size:clamp(32px,4vw,52px)">Diagnose & treat <span>plant problems.</span></h1>
        <p>Identify yellow leaves, root rot, spider mites, underwatering, and fungal diseases with expert step-by-step treatment guidance.</p>
      </div>
      <div class="hero-image" style="min-height:380px">
        <img src="{{ asset('images/placeholders/doctor_banner.jpg') }}" alt="Plant Doctor" class="skeleton-img">
      </div>
    </div>
  </div>
</section>

<!-- Filter & Problem Directory -->
<section class="section">
  <div class="container">
    <form method="GET" action="{{ route('problems.index') }}" class="search-box mb-5" style="grid-template-columns: 1.4fr 1fr 1fr auto;">
      <label class="field">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input name="search" type="text" placeholder="Search symptom (e.g. Yellow Leaves, Mites)..." value="{{ request('search') }}" />
      </label>

      <label class="field">
        <i class="fa-solid fa-layer-group"></i>
        <select name="type" onchange="this.form.submit()">
          <option value="">All Problem Types</option>
          <option value="disease" {{ request('type') === 'disease' ? 'selected' : '' }}>Diseases</option>
          <option value="pest" {{ request('type') === 'pest' ? 'selected' : '' }}>Pests / Insects</option>
          <option value="watering" {{ request('type') === 'watering' ? 'selected' : '' }}>Watering Issues</option>
          <option value="nutrient" {{ request('type') === 'nutrient' ? 'selected' : '' }}>Nutrient Deficiency</option>
        </select>
      </label>

      <label class="field">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <select name="severity" onchange="this.form.submit()">
          <option value="">All Severities</option>
          <option value="high" {{ request('severity') === 'high' ? 'selected' : '' }}>High Severity</option>
          <option value="medium" {{ request('severity') === 'medium' ? 'selected' : '' }}>Medium Severity</option>
          <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low Severity</option>
        </select>
      </label>

      <button type="submit" class="btn" style="background:var(--green-900);color:white">Search <i class="fa-solid fa-arrow-right"></i></button>
    </form>

    <div class="row g-4">
      @forelse($problems as $prob)
        <div class="col-md-6 col-lg-4">
          <div class="p-4 bg-white border rounded-4 h-100 shadow-sm transition-hover">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="badge bg-light text-dark text-capitalize">{{ $prob->problem_type }}</span>
              @if($prob->severity === 'high')
                <span class="badge bg-danger">Urgent Action</span>
              @else
                <span class="badge bg-warning text-dark">{{ ucfirst($prob->severity) }} Severity</span>
              @endif
            </div>

            <h3 class="fw-bold mb-2" style="font-size:22px"><a href="{{ route('problems.show', $prob->slug) }}" class="text-dark text-decoration-none">{{ $prob->name }}</a></h3>
            <p class="text-muted small mb-4">{{ Str::limit($prob->short_description, 110) }}</p>

            <a href="{{ route('problems.show', $prob->slug) }}" class="btn btn-outline-success w-100 fw-bold" style="border-radius:12px">
              View Diagnosis & Treatment <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-solid fa-user-doctor fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No plant problems match your search query.</h4>
          <a href="{{ route('problems.index') }}" class="btn btn-outline-success mt-2">View All Plant Problems</a>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $problems->links() }}
    </div>
  </div>
</section>
@endsection
