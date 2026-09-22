@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Hero Header -->
<section class="hero" style="padding-bottom:10px">
  <div class="container">
    <div class="hero-grid" style="min-height:380px;background:linear-gradient(135deg, var(--green-950), var(--green-900))">
      <div class="hero-copy" style="padding:48px 42px">
        <span class="eyebrow" style="background:rgba(255,255,255,.1);color:#dff2ca"><i class="fa-solid fa-book-open me-1"></i> Comprehensive Guides</span>
        <h1 style="font-size:clamp(32px,4vw,52px)">Master plant care <span>step by step.</span></h1>
        <p>Detailed plant repotting manuals, vegetable growing guides, potting soil recipes, and seasonal plant maintenance instruction sets.</p>
      </div>
      <div class="hero-image" style="min-height:380px">
        <img src="{{ asset('images/placeholders/shop_banner.jpg') }}" alt="Plant Guides" class="skeleton-img">
      </div>
    </div>
  </div>
</section>

<!-- Guides Grid -->
<section class="section">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
      <div class="d-flex gap-2 overflow-x-auto pb-2">
        <a href="{{ route('guides.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-secondary' }}" style="border-radius:12px">All Guides</a>
        @foreach($categories as $cat)
          <a href="{{ route('guides.index', ['category' => $cat->slug]) }}" class="btn btn-sm {{ request('category') === $cat->slug ? 'btn-success' : 'btn-outline-secondary' }}" style="border-radius:12px">{{ $cat->name }}</a>
        @endforeach
      </div>

      <form method="GET" action="{{ route('guides.index') }}" class="d-flex gap-2 max-w-300">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search guides..." value="{{ request('search') }}" style="border-radius:10px">
        <button type="submit" class="btn btn-sm btn-dark" style="border-radius:10px"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>

    <div class="row g-4">
      @forelse($guides as $post)
        <div class="col-md-6 col-lg-4">
          <article class="product-card h-100">
            <div class="product-media" style="height:220px">
              <img src="{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : asset('images/placeholders/shop_banner.jpg') }}" alt="{{ $post->title }}">
              <span class="badge position-absolute top-0 start-0 m-3 bg-success text-white shadow-sm"><i class="fa-solid fa-book-open me-1"></i> Guide</span>
            </div>
            <div class="product-body d-flex flex-column">
              <div class="small text-muted mb-2">
                <i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time ?: 6 }} min read &bull; {{ $post->category?->name ?: 'General Care' }}
              </div>
              <h3 class="fw-bold mb-2" style="font-size:20px"><a href="{{ route('guides.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h3>
              <p class="text-muted small mb-4 flex-grow-1">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}</p>
              
              <a href="{{ route('guides.show', $post->slug) }}" class="btn btn-outline-success w-100 fw-bold mt-auto" style="border-radius:12px">
                Open Guide <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-solid fa-book-open fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No plant care guides match your search filter.</h4>
          <a href="{{ route('guides.index') }}" class="btn btn-outline-success mt-2">View All Guides</a>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $guides->links() }}
    </div>
  </div>
</section>
@endsection
