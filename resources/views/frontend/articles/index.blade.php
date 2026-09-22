@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Hero Header -->
<section class="hero" style="padding-bottom:10px">
  <div class="container">
    <div class="hero-grid" style="min-height:380px;background:linear-gradient(135deg, var(--green-950), var(--green-900))">
      <div class="hero-copy" style="padding:48px 42px">
        <span class="eyebrow" style="background:rgba(255,255,255,.1);color:#dff2ca"><i class="fa-regular fa-newspaper me-1"></i> Botanical Knowledge</span>
        <h1 style="font-size:clamp(32px,4vw,52px)">Discover expert <span>gardening articles.</span></h1>
        <p>In-depth guides, plant care insights, indoor foliage tips, and organic gardening strategies written by Plantaric horticulturists.</p>
      </div>
      <div class="hero-image" style="min-height:380px">
        <img src="{{ asset('images/placeholders/news_banner.jpg') }}" alt="Gardening Articles" class="skeleton-img">
      </div>
    </div>
  </div>
</section>

<!-- Featured Article Hero -->
@if(isset($featuredArticle) && $featuredArticle)
<section class="section py-4">
  <div class="container">
    <div class="p-4 p-md-5 bg-white border rounded-4 shadow-sm overflow-hidden">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6">
          <span class="badge bg-success-subtle text-success text-uppercase mb-2">Featured Article</span>
          <h2 class="fw-bold mb-3" style="font-family:'Playfair Display',serif;font-size:clamp(24px,3vw,38px)">
            <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="text-dark text-decoration-none">{{ $featuredArticle->title }}</a>
          </h2>
          <p class="text-muted lead mb-4">{{ Str::limit($featuredArticle->excerpt ?: strip_tags($featuredArticle->content), 160) }}</p>
          <div class="d-flex align-items-center gap-3">
            <span class="small text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $featuredArticle->reading_time ?: 5 }} min read</span>
            <span class="small text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ $featuredArticle->published_at ? $featuredArticle->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
            <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="btn btn-success ms-auto" style="border-radius:12px;font-weight:700">Read Article <i class="fa-solid fa-arrow-right ms-1"></i></a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="rounded-4 overflow-hidden shadow-sm" style="height:320px">
            <img src="{{ $featuredArticle->featuredImage ? asset('storage/' . $featuredArticle->featuredImage->file_path) : asset('images/placeholders/news_banner.jpg') }}" alt="{{ $featuredArticle->title }}" class="w-100 h-100 object-fit-cover">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Filter & Article Grid -->
<section class="section">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
      <div class="d-flex gap-2 overflow-x-auto pb-2">
        <a href="{{ route('articles.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-secondary' }}" style="border-radius:12px">All Articles</a>
        @foreach($categories as $cat)
          <a href="{{ route('articles.index', ['category' => $cat->slug]) }}" class="btn btn-sm {{ request('category') === $cat->slug ? 'btn-success' : 'btn-outline-secondary' }}" style="border-radius:12px">{{ $cat->name }}</a>
        @endforeach
      </div>

      <form method="GET" action="{{ route('articles.index') }}" class="d-flex gap-2 max-w-300">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search articles..." value="{{ request('search') }}" style="border-radius:10px">
        <button type="submit" class="btn btn-sm btn-dark" style="border-radius:10px"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>

    <div class="row g-4">
      @forelse($articles as $post)
        <div class="col-md-6 col-lg-4">
          <article class="product-card h-100">
            <div class="product-media" style="height:220px">
              <img src="{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : asset('images/placeholders/news_banner.jpg') }}" alt="{{ $post->title }}">
              @if($post->category)
                <span class="badge position-absolute top-0 start-0 m-3 bg-white text-dark shadow-sm">{{ $post->category->name }}</span>
              @endif
            </div>
            <div class="product-body d-flex flex-column">
              <div class="small text-muted mb-2">
                <i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time ?: 4 }} min read &bull; {{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}
              </div>
              <h3 class="fw-bold mb-2" style="font-size:20px"><a href="{{ route('articles.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h3>
              <p class="text-muted small mb-4 flex-grow-1">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}</p>
              
              <a href="{{ route('articles.show', $post->slug) }}" class="btn btn-outline-success w-100 fw-bold mt-auto" style="border-radius:12px">
                Read Article <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-regular fa-newspaper fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No articles match your search filter.</h4>
          <a href="{{ route('articles.index') }}" class="btn btn-outline-success mt-2">View All Articles</a>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $articles->links() }}
    </div>
  </div>
</section>
@endsection
