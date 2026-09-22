@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Author Hero Box -->
<section class="section bg-light py-5 border-bottom">
  <div class="container">
    <div class="max-w-900 mx-auto bg-white p-4 p-md-5 rounded-4 shadow-sm border">
      <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start text-center text-md-start gap-4">
        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm" style="width:110px;height:110px;object-fit:cover">
        <div>
          <span class="badge bg-success-subtle text-success text-uppercase mb-2"><i class="fa-regular fa-user me-1"></i> Author Profile</span>
          <h1 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">{{ $user->name }}</h1>
          <p class="text-muted fw-bold mb-3">{{ $user->authorProfile?->job_title ?: 'Botanical Editor & Plant Specialist' }}</p>
          <p class="text-secondary mb-4">{{ $user->authorProfile?->bio ?: "Horticulturist and botanical author sharing expert indoor plant care guides, soil treatment advice, and gardening tutorials on Plantaric." }}</p>
          
          <div class="d-flex justify-content-center justify-content-md-start gap-3">
            @if($user->authorProfile?->website)
              <a href="{{ $user->authorProfile->website }}" target="_blank" class="btn btn-sm btn-outline-secondary" style="border-radius:10px"><i class="fa-solid fa-globe me-1"></i> Website</a>
            @endif
            @if($user->authorProfile?->twitter_handle)
              <a href="https://twitter.com/{{ ltrim($user->authorProfile->twitter_handle, '@') }}" target="_blank" class="btn btn-sm btn-outline-dark" style="border-radius:10px"><i class="fa-brands fa-x-twitter me-1"></i> Twitter</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Author Posts Listing -->
<section class="section py-5">
  <div class="container">
    <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Published Content by {{ $user->name }}</h3>
    <div class="row g-4">
      @forelse($posts as $post)
        <div class="col-md-6 col-lg-4">
          <article class="product-card h-100">
            <div class="product-media" style="height:200px">
              <img src="{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : asset('images/placeholders/news_banner.jpg') }}" alt="{{ $post->title }}">
              <span class="badge position-absolute top-0 start-0 m-3 bg-dark text-white shadow-sm">{{ $post->type->label() }}</span>
            </div>
            <div class="product-body d-flex flex-column">
              <div class="small text-muted mb-2">
                <i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}
              </div>
              <h4 class="fw-bold mb-2" style="font-size:18px"><a href="{{ $post->public_url }}" class="text-dark text-decoration-none">{{ $post->title }}</a></h4>
              <p class="text-muted small mb-4 flex-grow-1">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 100) }}</p>
              
              <a href="{{ $post->public_url }}" class="btn btn-outline-success w-100 fw-bold mt-auto" style="border-radius:12px">
                Read Post <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="fa-regular fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
          <h4>No published posts by this author yet.</h4>
        </div>
      @endforelse
    </div>

    <div class="mt-5">
      {{ $posts->links() }}
    </div>
  </div>
</section>
@endsection
