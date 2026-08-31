@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Category Header -->
<section class="section bg-light py-5 border-bottom">
  <div class="container text-center">
    <span class="badge bg-success text-white text-uppercase mb-3"><i class="fa-solid fa-folder-tree me-1"></i> Category</span>
    <h1 class="fw-bold mb-2" style="font-family:'Playfair Display',serif;font-size:clamp(32px,4vw,48px)">{{ $category->name }}</h1>
    <p class="text-muted lead max-w-700 mx-auto">{{ $category->description ?: "Explore all published articles, guides, and news under {$category->name} on Plantaric." }}</p>
  </div>
</section>

<!-- Category Posts Grid -->
<section class="section py-5">
  <div class="container">
    <div class="row g-4">
      @forelse($posts as $post)
        <div class="col-md-6 col-lg-4">
          <article class="product-card h-100">
            <div class="product-media" style="height:220px">
              <img src="{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : 'https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=700&q=85' }}" alt="{{ $post->title }}">
              <span class="badge position-absolute top-0 start-0 m-3 bg-dark text-white shadow-sm">{{ $post->type->label() }}</span>
            </div>
            <div class="product-body d-flex flex-column">
              <div class="small text-muted mb-2">
                <i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time ?: 4 }} min read &bull; {{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}
              </div>
              <h3 class="fw-bold mb-2" style="font-size:20px"><a href="{{ $post->public_url }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h3>
              <p class="text-muted small mb-4 flex-grow-1">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 110) }}</p>
              
              <a href="{{ $post->public_url }}" class="btn btn-outline-success w-100 fw-bold mt-auto" style="border-radius:12px">
                Read Post <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No posts found in {{ $category->name }} category yet.</h4>
          <a href="{{ route('articles.index') }}" class="btn btn-outline-success mt-2">View All Articles</a>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $posts->links() }}
    </div>
  </div>
</section>
@endsection
