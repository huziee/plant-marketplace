@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@push('styles')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ e($post->title) }}",
  "description": "{{ e($post->excerpt ?: str($post->content)->stripTags()->limit(150)) }}",
  "image": "{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : asset('images/plantaric-og.jpg') }}",
  "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ e($post->author?->name ?: 'Plantaric Newsroom') }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ setting('site_name', 'Plantaric') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('images/plantaric-logo.png') }}"
    }
  }
}
</script>
@endpush

@section('content')
<div class="bg-light py-3 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small fw-bold">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('news.index') }}" class="text-decoration-none text-muted">News</a></li>
        <li class="breadcrumb-item active text-success" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
      </ol>
    </nav>
  </div>
</div>

<article class="section py-5">
  <div class="container">
    <div class="max-w-900 mx-auto">
      <div class="mb-4">
        <span class="badge bg-dark text-white text-uppercase mb-3"><i class="fa-regular fa-newspaper me-1"></i> News Report</span>
        <h1 class="fw-bold mb-3" style="font-size:clamp(32px,4vw,52px);font-family:'Playfair Display',serif">{{ $post->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $post->excerpt }}</p>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-light rounded-4 border">
          <div class="d-flex align-items-center gap-4 text-muted small">
            <span><i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
            <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($post->views) }} views</span>
          </div>
        </div>
      </div>

      @if($post->featuredImage)
        <div class="rounded-4 overflow-hidden mb-5 shadow-sm border" style="max-height:480px">
          <img src="{{ asset('storage/' . $post->featuredImage->file_path) }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover">
        </div>
      @endif

      <x-ad-slot name="news_after_intro" />

      <div class="content-body entry-content mb-5" style="font-size:18px;line-height:1.8;color:#2c3e50">
        {!! $post->content !!}
      </div>

      <x-ad-slot name="news_bottom" />

      <!-- News Sources -->
      @if($post->sources->count() > 0)
        <div class="p-4 bg-light rounded-4 border mb-5">
          <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-bookmark me-2 text-success"></i> News Sources & References</h5>
          <ul class="mb-0">
            @foreach($post->sources as $source)
              <li class="small text-muted mb-2">
                <a href="{{ $source->url }}" target="_blank" rel="noopener" class="fw-bold text-dark text-decoration-underline">{{ $source->title }}</a>
                @if($source->publisher) &bull; {{ $source->publisher }} @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Related News -->
      @if($relatedPosts->count() > 0)
        <div class="pt-4 border-top">
          <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Related News & Articles</h3>
          <div class="row g-4">
            @foreach($relatedPosts as $rel)
              <div class="col-md-6">
                <div class="p-4 bg-white border rounded-4 h-100">
                  <span class="badge bg-light text-dark text-uppercase mb-2">{{ $rel->type->label() }}</span>
                  <h4 class="fw-bold mb-2"><a href="{{ $rel->public_url }}" class="text-dark text-decoration-none">{{ $rel->title }}</a></h4>
                  <p class="text-muted small mb-3">{{ Str::limit($rel->excerpt ?: strip_tags($rel->content), 100) }}</p>
                  <a href="{{ $rel->public_url }}" class="fw-bold text-success text-decoration-none">Read Story <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</article>
@endsection
