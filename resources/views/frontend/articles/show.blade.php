@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@push('styles')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ e($post->title) }}",
  "description": "{{ e($post->excerpt ?: str($post->content)->stripTags()->limit(150)) }}",
  "image": "{{ $post->featuredImage ? asset('storage/' . $post->featuredImage->file_path) : asset('images/plantaric-og.jpg') }}",
  "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : now()->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ e($post->author?->name ?: 'Plantaric Team') }}"
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
<!-- Breadcrumb Header -->
<div class="bg-light py-3 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small fw-bold">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('articles.index') }}" class="text-decoration-none text-muted">Articles</a></li>
        @if($post->category)
          <li class="breadcrumb-item"><a href="{{ route('content-categories.show', $post->category->slug) }}" class="text-decoration-none text-muted">{{ $post->category->name }}</a></li>
        @endif
        <li class="breadcrumb-item active text-success" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
      </ol>
    </nav>
  </div>
</div>

<article class="section py-5">
  <div class="container">
    <div class="max-w-900 mx-auto">
      @if(isset($isPreview) && $isPreview)
        <div class="alert alert-warning border-0 mb-4" style="border-radius:14px">
          <i class="fa-solid fa-triangle-exclamation me-2"></i> <strong>Admin Preview Mode:</strong> This post is currently in <code>{{ $post->status->label() }}</code> status and not yet public.
        </div>
      @endif

      <!-- Article Header -->
      <div class="mb-4">
        @if($post->category)
          <span class="badge bg-success-subtle text-success text-uppercase mb-3">{{ $post->category->name }}</span>
        @endif

        <h1 class="fw-bold mb-3" style="font-size:clamp(32px,4vw,52px);font-family:'Playfair Display',serif;line-height:1.2">{{ $post->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $post->excerpt }}</p>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-light rounded-4 border">
          <div class="d-flex align-items-center gap-4 text-muted small">
            <span><i class="fa-regular fa-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
            <span><i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time ?: 5 }} min read</span>
            <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($post->views) }} views</span>
          </div>
        </div>
      </div>

      <!-- Featured Header Image -->
      @if($post->featuredImage)
        <div class="rounded-4 overflow-hidden mb-5 shadow-sm border" style="max-height:480px">
          <img src="{{ asset('storage/' . $post->featuredImage->file_path) }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover">
        </div>
      @endif

      <x-ad-slot name="article_after_intro" />

      <!-- Article Body Content -->
      <div class="content-body entry-content mb-5" style="font-size:18px;line-height:1.8;color:#2c3e50">
        {!! $post->content !!}
      </div>

      <x-ad-slot name="article_bottom" />

      <!-- Post Sources & References -->
      @if($post->sources->count() > 0)
        <div class="p-4 bg-light rounded-4 border mb-5">
          <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-bookmark me-2 text-success"></i> References & Sources</h5>
          <ul class="mb-0">
            @foreach($post->sources as $source)
              <li class="small text-muted mb-2">
                <a href="{{ $source->url }}" target="_blank" rel="noopener" class="fw-bold text-dark text-decoration-underline">{{ $source->title }}</a>
                @if($source->publisher) &bull; {{ $source->publisher }} @endif
                @if($source->published_at) ({{ $source->published_at->format('Y') }}) @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Botanical Advice Disclaimer Notice -->
      <div class="p-3 bg-light rounded-4 border mb-5 text-muted small">
        <i class="fa-solid fa-circle-info text-success me-2"></i> <strong>Botanical Care Disclaimer:</strong> Content, guides, and diagnostic advice on Plantaric are published for general educational purposes. Please consult our <a href="{{ route('frontend.terms') }}#disclaimer" class="text-success text-decoration-underline fw-bold">Terms & Conditions</a> for full botanical disclaimers.
      </div>

      <!-- Social Share Buttons -->
      <div class="d-flex align-items-center gap-2 p-3 bg-white border rounded-4 shadow-sm mb-5">
        <span class="fw-bold me-2 text-dark small">Share Article:</span>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->public_url) }}" target="_blank" class="btn btn-sm btn-outline-primary" style="border-radius:10px"><i class="fa-brands fa-facebook-f"></i> Facebook</a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode($post->public_url) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-sm btn-outline-dark" style="border-radius:10px"><i class="fa-brands fa-x-twitter"></i> Twitter</a>
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($post->public_url) }}" target="_blank" class="btn btn-sm btn-outline-secondary" style="border-radius:10px"><i class="fa-brands fa-linkedin-in"></i> LinkedIn</a>
        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . $post->public_url) }}" target="_blank" class="btn btn-sm btn-outline-success" style="border-radius:10px"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
      </div>

      <!-- Linked Plants Section -->
      @if($post->plants->count() > 0)
        <div class="pt-4 border-top mb-5">
          <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-leaf text-success me-2"></i> Mentioned Plants in this Article</h3>
          <div class="row g-4">
            @foreach($post->plants as $p)
              <div class="col-md-6">
                <div class="p-3 bg-white border rounded-4 d-flex align-items-center gap-3">
                  <img src="{{ $p->featuredImage ? asset('storage/' . $p->featuredImage->file_path) : asset('images/placeholders/plant_placeholder.jpg') }}" class="rounded-3" style="width:64px;height:64px;object-fit:cover">
                  <div>
                    <h5 class="fw-bold mb-1"><a href="{{ route('plants.show', $p->slug) }}" class="text-dark text-decoration-none">{{ $p->name }}</a></h5>
                    <span class="small text-muted fst-italic">{{ $p->scientific_name }}</span>
                    <a href="{{ route('plants.show', $p->slug) }}" class="d-block small text-success fw-bold mt-1">View Care Profile <i class="fa-solid fa-arrow-right"></i></a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Related Content -->
      @if($relatedPosts->count() > 0)
        <div class="pt-4 border-top">
          <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Related Reading You May Like</h3>
          <div class="row g-4">
            @foreach($relatedPosts as $rel)
              <div class="col-md-6">
                <div class="p-4 bg-white border rounded-4 h-100">
                  <span class="badge bg-light text-dark text-uppercase mb-2">{{ $rel->type->label() }}</span>
                  <h4 class="fw-bold mb-2"><a href="{{ $rel->public_url }}" class="text-dark text-decoration-none">{{ $rel->title }}</a></h4>
                  <p class="text-muted small mb-3">{{ Str::limit($rel->excerpt ?: strip_tags($rel->content), 100) }}</p>
                  <a href="{{ $rel->public_url }}" class="fw-bold text-success text-decoration-none">Read Now <i class="fa-solid fa-arrow-right ms-1"></i></a>
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
