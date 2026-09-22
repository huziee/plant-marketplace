@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Hero Header -->
<section class="hero" style="padding-bottom:10px">
  <div class="container">
    <div class="hero-grid" style="min-height:380px;background:linear-gradient(135deg, var(--green-950), var(--green-900))">
      <div class="hero-copy" style="padding:48px 42px">
        <span class="eyebrow"><i class="fa-solid fa-book-open"></i> Botanical Database</span>
        <h1 style="font-size:clamp(32px,4vw,52px)">Plant Encyclopedia & <span>Care Guides.</span></h1>
        <p>Explore detailed care guides, watering frequencies, sunlight levels, soil requirements, and growing instructions for hundreds of indoor and outdoor plant species.</p>
      </div>
      <div class="hero-image" style="min-height:380px">
        <img src="{{ asset('images/placeholders/plant_placeholder.jpg') }}" alt="Plant Encyclopedia" class="skeleton-img">
      </div>
    </div>
  </div>
</section>

<!-- Filter & Directory Strip -->
<section class="section">
  <div class="container">
    <form method="GET" action="{{ route('plants.index') }}" class="search-box mb-5" style="grid-template-columns: 1.4fr 1fr 1fr 1fr auto;">
      <label class="field">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input name="search" type="text" placeholder="Search plant names, scientific name..." value="{{ request('search') }}" />
      </label>
      
      <label class="field">
        <i class="fa-solid fa-layer-group"></i>
        <select name="category" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </label>

      <label class="field">
        <i class="fa-solid fa-seedling"></i>
        <select name="difficulty" onchange="this.form.submit()">
          <option value="">All Difficulties</option>
          <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Easy Care</option>
          <option value="moderate" {{ request('difficulty') === 'moderate' ? 'selected' : '' }}>Moderate Care</option>
          <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced / Expert</option>
        </select>
      </label>

      <label class="field">
        <i class="fa-solid fa-house-plant"></i>
        <select name="environment" onchange="this.form.submit()">
          <option value="">Indoor / Outdoor</option>
          <option value="indoor" {{ request('environment') === 'indoor' ? 'selected' : '' }}>Indoor Only</option>
          <option value="outdoor" {{ request('environment') === 'outdoor' ? 'selected' : '' }}>Outdoor Only</option>
        </select>
      </label>

      <button type="submit" class="btn" style="background:var(--green-900);color:white">Filter <i class="fa-solid fa-arrow-right"></i></button>
    </form>

    <!-- Plant Cards Grid -->
    <div class="product-grid">
      @forelse($plants as $plant)
        <article class="product-card">
          <div class="product-media">
            <img src="{{ $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : asset('images/placeholders/plant_placeholder.jpg') }}" alt="{{ $plant->name }}" class="skeleton-img">
            <span class="badge text-capitalize" style="background:var(--green-900);color:white">{{ $plant->difficulty }} Care</span>
            <button class="wish"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div class="product-body">
            <div class="d-flex align-items-center gap-2 mb-2">
              @if($plant->pet_safe)
                <span class="care-pill care-pill-green"><i class="fa-solid fa-paw"></i> Pet Safe</span>
              @endif
              @if($plant->air_purifying)
                <span class="care-pill care-pill-purple"><i class="fa-solid fa-wind"></i> Air Purifying</span>
              @endif
            </div>

            <h3 class="fw-bold mb-1"><a href="{{ route('plants.show', $plant->slug) }}">{{ $plant->name }}</a></h3>
            <p class="text-muted small fst-italic mb-3">{{ $plant->scientific_name }}</p>

            <div class="product-meta border-top pt-2">
              <span><i class="fa-solid fa-sun text-warning me-1"></i> {{ $plant->care?->sunlight_label ?: 'Bright Indirect' }}</span>
              <span><i class="fa-solid fa-droplet text-primary me-1"></i> {{ $plant->care?->watering_label ?: 'Weekly' }}</span>
            </div>

            <a href="{{ route('plants.show', $plant->slug) }}" class="btn btn-outline-success w-100 mt-3" style="border-radius:12px;font-weight:700">
              View Care Guide <i class="fa-solid fa-arrow-right me-1"></i>
            </a>
          </div>
        </article>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-solid fa-leaf fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No plants match your search criteria.</h4>
          <p>Try clearing filters or searching for another plant name.</p>
          <a href="{{ route('plants.index') }}" class="btn btn-outline-success mt-2">View All Plants</a>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $plants->links() }}
    </div>
  </div>
</section>
@endsection
