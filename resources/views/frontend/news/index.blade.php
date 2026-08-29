@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Hero Header -->
<section class="hero" style="padding-bottom:10px">
  <div class="container">
    <div class="hero-grid" style="min-height:380px;background:linear-gradient(135deg, var(--green-950), var(--green-900))">
      <div class="hero-copy" style="padding:48px 42px">
        <span class="eyebrow" style="background:rgba(255,255,255,.1);color:#dff2ca"><i class="fa-regular fa-newspaper me-1"></i> Industry News</span>
        <h1 style="font-size:clamp(32px,4vw,52px)">Plant & agriculture <span>news updates.</span></h1>
        <p>Stay informed with regional urban farming developments, nursery industry trends, new plant varieties, and agricultural technology.</p>
      </div>
      <div class="hero-image" style="min-height:380px">
        <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1200&q=85" alt="Plant News" class="skeleton-img">
      </div>
    </div>
  </div>
</section>

<!-- News Grid -->
<section class="section">
  <div class="container">
    <div class="row g-4">
      @forelse($newsPosts as $post)
        <div class="col-md-6 col-lg-4">
          <article class="product-card h-100">
            <div class="product-media" style="height:220px">
              <img src="{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=700&q=85' }}" alt="{{ $post->title }}">
              <span class="badge position-absolute top-0 start-0 m-3 bg-dark text-white shadow-sm">NEWS</span>
            </div>
            <div class="product-body d-flex flex-column">
              <div class="small text-muted mb-2">
                <i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}
              </div>
              <h3 class="fw-bold mb-2" style="font-size:20px"><a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h3>
              <p class="text-muted small mb-4 flex-grow-1">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}</p>
              
              <a href="{{ route('news.show', $post->slug) }}" class="btn btn-outline-dark w-100 fw-bold mt-auto" style="border-radius:12px">
                Read Full Story <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-regular fa-newspaper fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No news posts available at the moment.</h4>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $newsPosts->links() }}
    </div>
  </div>
</section>
@endsection
