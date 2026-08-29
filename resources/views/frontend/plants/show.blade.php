@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@push('styles')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "WebPage",
  "name": "{{ e($plant->name) }} Care Guide",
  "description": "{{ e($plant->short_description) }}",
  "url": "{{ url()->current() }}"
}
</script>
@endpush

@section('content')
<!-- Breadcrumb Header -->
<div class="bg-light py-3 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small fw-bold">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('plants.index') }}" class="text-decoration-none text-muted">Plants</a></li>
        @if($plant->category)
          <li class="breadcrumb-item"><a href="{{ route('plants.index', ['category' => $plant->category->slug]) }}" class="text-decoration-none text-muted">{{ $plant->category->name }}</a></li>
        @endif
        <li class="breadcrumb-item active text-success" aria-current="page">{{ $plant->name }}</li>
      </ol>
    </nav>
  </div>
</div>

<section class="section py-5">
  <div class="container">
    <div class="row g-5">
      <!-- Left Column: Image Gallery -->
      <div class="col-lg-6">
        <div class="rounded-4 overflow-hidden shadow-sm border mb-3 bg-white" style="height:440px">
          <img id="mainPlantImg" src="{{ $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=1000&q=85' }}" alt="{{ $plant->name }}" class="w-100 h-100 object-fit-cover skeleton-img">
        </div>

        @if($plant->images->count() > 0)
          <div class="d-flex gap-2 overflow-x-auto pb-2">
            @foreach($plant->images as $img)
              <img src="{{ asset('storage/' . $img->media->file_path) }}" class="rounded-3 border cursor-pointer thumbnail-img" style="width:80px;height:80px;object-fit:cover" onclick="document.getElementById('mainPlantImg').src=this.src">
            @endforeach
          </div>
        @endif
      </div>

      <!-- Right Column: Quick Info & Taxonomy -->
      <div class="col-lg-6">
        <div class="d-flex align-items-center gap-2 mb-2">
          @if($plant->category)
            <span class="badge bg-success-subtle text-success">{{ $plant->category->name }}</span>
          @endif
          <span class="badge bg-light text-dark text-capitalize"><i class="fa-solid fa-seedling me-1"></i> {{ $plant->difficulty }} Care</span>
          @if($plant->pet_safe)
            <span class="care-pill care-pill-green"><i class="fa-solid fa-paw"></i> Pet Safe</span>
          @else
            <span class="care-pill care-pill-purple" style="background:#fee2e2;color:#991b1b"><i class="fa-solid fa-triangle-exclamation"></i> Toxic if ingested</span>
          @endif
        </div>

        <h1 class="fw-bold mb-1" style="font-size:clamp(32px,4vw,48px)">{{ $plant->name }}</h1>
        <p class="text-muted fs-5 fst-italic mb-3">{{ $plant->scientific_name }}</p>

        @if($plant->commonNames->count() > 0)
          <p class="small text-muted mb-4">
            <strong>Also known as:</strong> {{ $plant->commonNames->pluck('name')->implode(', ') }}
          </p>
        @endif

        <p class="lead text-secondary mb-4">{{ $plant->short_description }}</p>

        <!-- Quick Care Summary Box -->
        <div class="p-4 rounded-4 bg-white border shadow-sm mb-4">
          <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Quick Care Summary</h5>
          <div class="row g-3 text-center">
            <div class="col-4">
              <div class="p-2 rounded-3 bg-light">
                <i class="fa-solid fa-sun text-warning fa-lg mb-1"></i>
                <div class="small fw-bold">{{ ($plant->care ? $plant->care->sunlight_label : null) ?: 'Bright Indirect' }}</div>
              </div>
            </div>
            <div class="col-4">
              <div class="p-2 rounded-3 bg-light">
                <i class="fa-solid fa-droplet text-primary fa-lg mb-1"></i>
                <div class="small fw-bold">{{ ($plant->care ? $plant->care->watering_label : null) ?: 'Weekly' }}</div>
              </div>
            </div>
            <div class="col-4">
              <div class="p-2 rounded-3 bg-light">
                <i class="fa-solid fa-temperature-half text-danger fa-lg mb-1"></i>
                <div class="small fw-bold">{{ ($plant->care ? $plant->care->temperature_min : null) ?: 15 }}°C – {{ ($plant->care ? $plant->care->temperature_max : null) ?: 30 }}°C</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Care Guides Detailed Sections -->
    <div class="mt-5">
      <h2 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Complete Care Instructions</h2>

      <div class="row g-4">
        @if($plant->care && $plant->care->sunlight_description)
          <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 border h-100">
              <h4 class="fw-bold text-success mb-2"><i class="fa-solid fa-sun text-warning me-2"></i> Sunlight Requirements</h4>
              <p class="text-muted mb-0">{{ $plant->care->sunlight_description }}</p>
            </div>
          </div>
        @endif

        @if($plant->care && $plant->care->watering_description)
          <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 border h-100">
              <h4 class="fw-bold text-success mb-2"><i class="fa-solid fa-droplet text-primary me-2"></i> Watering Schedule</h4>
              <p class="text-muted mb-0">{{ $plant->care->watering_description }}</p>
            </div>
          </div>
        @endif

        @if($plant->care && $plant->care->soil_type)
          <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 border h-100">
              <h4 class="fw-bold text-success mb-2"><i class="fa-solid fa-mound me-2"></i> Soil & Drainage</h4>
              <p class="text-muted mb-0">{{ $plant->care->soil_type }} (Optimal pH: {{ $plant->care->soil_ph_min ?: 5.5 }} – {{ $plant->care->soil_ph_max ?: 7.0 }})</p>
            </div>
          </div>
        @endif

        @if($plant->care && $plant->care->care_tips)
          <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 border h-100">
              <h4 class="fw-bold text-success mb-2"><i class="fa-solid fa-lightbulb text-warning me-2"></i> Care Tips & Maintenance</h4>
              <p class="text-muted mb-0">{{ $plant->care->care_tips }}</p>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- Common Problems Section -->
    @if($plant->problems->count() > 0)
      <div class="mt-5 pt-4 border-top">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <span class="eyebrow"><i class="fa-solid fa-user-doctor"></i> Plant Health</span>
            <h2 class="fw-bold mt-2" style="font-family:'Playfair Display',serif">Common Problems for {{ $plant->name }}</h2>
          </div>
          <a href="{{ route('problems.index') }}" class="link-arrow">Browse all problems <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="row g-4">
          @foreach($plant->problems as $problem)
            <div class="col-md-4">
              <div class="p-4 bg-white border rounded-4 h-100">
                <span class="badge bg-danger-subtle text-danger text-capitalize mb-2">{{ $problem->problem_type }}</span>
                <h4 class="fw-bold mb-2">{{ $problem->name }}</h4>
                <p class="text-muted small mb-3">{{ Str::limit($problem->short_description, 100) }}</p>
                <a href="{{ route('problems.show', $problem->slug) }}" class="fw-bold text-success text-decoration-none">
                  Learn How to Fix <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- Related Plants -->
    @if($relatedPlants->count() > 0)
      <div class="mt-5 pt-4 border-top">
        <h2 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Related Plants You May Like</h2>
        <div class="product-grid">
          @foreach($relatedPlants as $rel)
            <article class="product-card">
              <div class="product-media">
                <img src="{{ $rel->featuredImage ? asset('storage/' . $rel->featuredImage->file_path) : 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85' }}" alt="{{ $rel->name }}">
                <span class="badge text-capitalize" style="background:var(--green-900);color:white">{{ $rel->difficulty }} Care</span>
              </div>
              <div class="product-body">
                <h3 class="fw-bold mb-1"><a href="{{ route('plants.show', $rel->slug) }}">{{ $rel->name }}</a></h3>
                <p class="text-muted small fst-italic mb-3">{{ $rel->scientific_name }}</p>
                <a href="{{ route('plants.show', $rel->slug) }}" class="btn btn-outline-success w-100" style="border-radius:12px;font-weight:700">View Plant</a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
