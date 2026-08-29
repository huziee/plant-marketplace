@extends('layouts.app')

@section('title', $category->seo_title ?: $category->name . ' - Plantora Store')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-muted">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
        <h1 class="h2 fw-bold text-dark mb-1">{{ $category->name }}</h1>
        @if($category->short_description)
            <p class="text-muted mb-0">{{ $category->short_description }}</p>
        @endif
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $cat)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <a href="{{ route('frontend.shop.category', $cat->slug) }}" class="text-decoration-none {{ $cat->id === $category->id ? 'fw-bold text-success' : 'text-dark' }}">
                                    {{ $cat->name }}
                                </a>
                                <span class="badge bg-light text-muted rounded-pill">{{ $cat->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                            @if($product->featuredImage)
                                <img src="{{ asset('storage/' . $product->featuredImage->file_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 220px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 220px;">
                                    <i class="fa-solid fa-leaf fa-3x"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <small class="text-muted text-uppercase mb-1">{{ $product->category->name }}</small>
                                <h5 class="card-title fw-bold">
                                    <a href="{{ route('frontend.shop.product', $product->slug) }}" class="text-decoration-none text-dark">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fs-5 fw-bold text-success">Rs. {{ number_format($product->price, 0) }}</span>
                                    <form action="{{ route('frontend.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-outline-success btn-sm rounded-pill">
                                            <i class="fa-solid fa-cart-plus me-1"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fa-solid fa-leaf text-muted fa-3x mb-3"></i>
                        <p class="text-muted">No products found in this category.</p>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
