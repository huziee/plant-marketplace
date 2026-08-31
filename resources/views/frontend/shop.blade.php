@extends('layouts.app')

@section('title', 'Plantaric Shop — Plants, Seeds, Pots & Care')
@section('meta_description', 'Browse nursery-grown indoor plants, outdoor shrubs, seeds, terracotta pots, fertilizers and plant care products.')

@section('content')
<!-- Shop Hero -->
<section class="hero" style="padding-bottom:10px">
  <div class="container">
    <div class="hero-grid" style="min-height:480px;background:linear-gradient(135deg, var(--green-950), var(--green-900))">
      <div class="hero-copy" style="padding:60px 48px">
        <span class="eyebrow"><i class="fa-solid fa-store"></i> Direct From Verified Local Nurseries</span>
        <h1 style="font-size:clamp(38px,5vw,62px)">Shop healthy plants & <span>gardening essentials.</span></h1>
        <p>Curated indoor foliage, outdoor flowering plants, organic seeds, ceramic pots, and eco-friendly plant care products delivered safely to your home.</p>
        <div class="hero-actions">
          <a href="#featured" class="btn btn-primary">Browse Catalog <i class="fa-solid fa-arrow-right"></i></a>
          <a href="#categories" class="btn btn-outline">Explore Categories</a>
        </div>
      </div>
      <div class="hero-image" style="min-height:480px">
        <img src="https://images.unsplash.com/photo-1463936575829-25148e1db1b8?auto=format&fit=crop&w=1200&q=85" alt="Plantaric Shop Collection" class="skeleton-img">
      </div>
    </div>
  </div>
</section>

<!-- Trust Benefits Strip -->
<section class="section-sm">
  <div class="container">
    <div class="row g-3 text-center">
      <div class="col-md-3">
        <div class="bg-white border p-3" style="border-radius:18px">
          <i class="fa-solid fa-truck-fast text-success fa-2x mb-2"></i>
          <h5 class="fw-bold mb-1" style="font-size:15px">Safe Express Delivery</h5>
          <p class="text-muted small mb-0">Specially packaged for plant safety</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="bg-white border p-3" style="border-radius:18px">
          <i class="fa-solid fa-shield-heart text-success fa-2x mb-2"></i>
          <h5 class="fw-bold mb-1" style="font-size:15px">14-Day Plant Guarantee</h5>
          <p class="text-muted small mb-0">Guaranteed healthy on arrival</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="bg-white border p-3" style="border-radius:18px">
          <i class="fa-solid fa-store text-success fa-2x mb-2"></i>
          <h5 class="fw-bold mb-1" style="font-size:15px">Verified Local Sellers</h5>
          <p class="text-muted small mb-0">Direct from expert local nurseries</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="bg-white border p-3" style="border-radius:18px">
          <i class="fa-solid fa-headset text-success fa-2x mb-2"></i>
          <h5 class="fw-bold mb-1" style="font-size:15px">Free Care Advice</h5>
          <p class="text-muted small mb-0">Talk to our plant doctor team</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Shop Categories -->
<section class="section" id="categories">
  <div class="container">
    <div class="section-head">
      <div>
        <span class="eyebrow">Shop By Category</span>
        <h2 style="margin-top:14px">What are you looking for?</h2>
      </div>
    </div>

    <div class="row g-3">
      @foreach($categories as $cat)
        <div class="col-md-4 col-lg-2.4">
          <a href="{{ route('frontend.shop.category', $cat->slug) }}" class="text-decoration-none">
            <div class="category text-start h-100 p-4">
              <div class="float-icon mb-3" style="width:48px;height:48px;font-size:20px">
                <i class="fa-solid {{ $cat->icon ?: 'fa-leaf' }}"></i>
              </div>
              <h4 class="fw-bold mb-1" style="font-size:17px">{{ $cat->name }}</h4>
              <p class="text-muted small mb-2">{{ Str::limit($cat->short_description ?: $cat->description, 50) }}</p>
              <span class="fw-bold text-success" style="font-size:12px">{{ $cat->products_count }} items</span>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Featured Products -->
<section class="section-sm" id="featured">
  <div class="container">
    <div class="section-head">
      <div>
        <span class="eyebrow">Curated Selection</span>
        <h2 style="margin-top:14px">Featured Products</h2>
      </div>
    </div>

    <div class="row g-4">
      @foreach($products as $item)
        <div class="col-md-4 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
            @if($item->featuredImage)
              <img src="{{ asset('storage/' . $item->featuredImage->file_path) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 220px; object-fit: cover;">
            @else
              <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 220px;">
                <i class="fa-solid fa-leaf fa-3x"></i>
              </div>
            @endif
            <div class="card-body d-flex flex-column">
              <span class="badge bg-success-subtle text-success border border-success align-self-start mb-2">{{ $item->category ? $item->category->name : 'General' }}</span>
              <h5 class="card-title fw-bold">
                <a href="{{ route('frontend.shop.product', $item->slug) }}" class="text-decoration-none text-dark">
                  {{ $item->name }}
                </a>
              </h5>
              <div class="mt-auto d-flex justify-content-between align-items-center">
                <span class="fs-5 fw-bold text-success">Rs. {{ number_format($item->price, 0) }}</span>
                <form action="{{ route('frontend.cart.add') }}" method="POST">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $item->id }}">
                  <button type="submit" class="btn btn-outline-success btn-sm rounded-pill">
                    <i class="fa-solid fa-cart-plus me-1"></i> Add
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @if($products->hasPages())
      <div class="mt-4">
        {{ $products->links() }}
      </div>
    @endif
  </div>
</section>
@endsection
