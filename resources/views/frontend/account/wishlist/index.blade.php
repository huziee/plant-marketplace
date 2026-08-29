@extends('layouts.app')

@section('title', 'My Wishlist - Plantora')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h1 class="h2 fw-bold text-dark mb-0">My Wishlist</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="list-group border-0 shadow-sm rounded-3">
                <a href="{{ route('frontend.account.dashboard') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>
                <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-box me-2"></i> My Orders
                </a>
                <a href="{{ route('frontend.account.addresses') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-location-dot me-2"></i> Addresses
                </a>
                <a href="{{ route('frontend.account.wishlist') }}" class="list-group-item list-group-item-action active fw-bold py-3">
                    <i class="fa-solid fa-heart me-2"></i> Wishlist
                </a>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($wishlistItems as $item)
                    @if($item->product)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                @if($item->product->featuredImage)
                                    <img src="{{ asset('storage/' . $item->product->featuredImage->file_path) }}" class="card-img-top" alt="{{ $item->product->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                                        <i class="fa-solid fa-leaf fa-3x"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h6 class="fw-bold mb-1">
                                        <a href="{{ route('frontend.shop.product', $item->product->slug) }}" class="text-decoration-none text-dark">
                                            {{ $item->product->name }}
                                        </a>
                                    </h6>
                                    <span class="fs-6 fw-bold text-success mb-3">Rs. {{ number_format($item->product->price, 0) }}</span>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <form action="{{ route('frontend.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                            <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-cart-plus me-1"></i> Add to Cart</button>
                                        </form>
                                        <form action="{{ route('frontend.wishlist.toggle', $item->product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fa-solid fa-heart text-muted fa-3x mb-3"></i>
                        <p class="text-muted">Your wishlist is empty.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-success">Browse Shop</a>
                    </div>
                @endforelse
            </div>
            @if($wishlistItems->hasPages())
                <div class="mt-4">
                    {{ $wishlistItems->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
