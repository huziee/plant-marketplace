@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Breadcrumb Header -->
<div class="bg-light py-3 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small fw-bold">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('guides.index') }}" class="text-decoration-none text-muted">Guides</a></li>
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
      <div class="mb-4">
        <span class="badge bg-success text-white text-uppercase mb-3"><i class="fa-solid fa-book-open me-1"></i> Plant Care Guide</span>
        <h1 class="fw-bold mb-3" style="font-size:clamp(32px,4vw,52px);font-family:'Playfair Display',serif">{{ $post->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $post->excerpt }}</p>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 bg-light rounded-4 border">
          <div class="d-flex align-items-center gap-3">
            <img src="{{ $post->author?->avatar_url }}" alt="{{ $post->author?->name }}" class="rounded-circle" style="width:44px;height:44px;object-fit:cover">
            <div>
              <a href="{{ route('authors.show', $post->author_id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $post->author?->name }}</a>
              <span class="small text-muted">Botanical Guide Author</span>
            </div>
          </div>
          <div class="d-flex align-items-center gap-4 text-muted small">
            <span><i class="fa-regular fa-clock me-1"></i> {{ $post->reading_time ?: 6 }} min read</span>
            <span><i class="fa-regular fa-eye me-1"></i> {{ number_format($post->views) }} views</span>
          </div>
        </div>
      </div>

      @if($post->featuredImage)
        <div class="rounded-4 overflow-hidden mb-5 shadow-sm border" style="max-height:480px">
          <img src="{{ asset('storage/' . $post->featuredImage->file_path) }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover">
        </div>
      @endif

      <x-ad-slot name="guide_after_intro" />

      <div class="content-body entry-content mb-5" style="font-size:18px;line-height:1.8;color:#2c3e50">
        {!! $post->content !!}
      </div>

      <x-ad-slot name="guide_bottom" />

      <!-- Linked Plants Section -->
      @if($post->plants->count() > 0)
        <div class="pt-4 border-top mb-5">
          <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-leaf text-success me-2"></i> Plants Featured in this Guide</h3>
          <div class="row g-4">
            @foreach($post->plants as $p)
              <div class="col-md-6">
                <div class="p-3 bg-white border rounded-4 d-flex align-items-center gap-3">
                  <img src="{{ $p->featuredImage ? asset('storage/' . $p->featuredImage->file_path) : 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=300&q=85' }}" class="rounded-3" style="width:64px;height:64px;object-fit:cover">
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
          <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Related Guides & Articles</h3>
          <div class="row g-4">
            @foreach($relatedPosts as $rel)
              <div class="col-md-6">
                <div class="p-4 bg-white border rounded-4 h-100">
                  <span class="badge bg-light text-dark text-uppercase mb-2">{{ $rel->type->label() }}</span>
                  <h4 class="fw-bold mb-2"><a href="{{ $rel->public_url }}" class="text-dark text-decoration-none">{{ $rel->title }}</a></h4>
                  <p class="text-muted small mb-3">{{ Str::limit($rel->excerpt ?: strip_tags($rel->content), 100) }}</p>
                  <a href="{{ $rel->public_url }}" class="fw-bold text-success text-decoration-none">Read Guide <i class="fa-solid fa-arrow-right ms-1"></i></a>
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
