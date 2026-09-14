@extends('layouts.app')

@section('title', $product->seo_title ?: $product->name . ' - Plantaric Store')

@section('content')
<div class="bg-light py-3 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" class="text-decoration-none text-muted">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-muted">Shop</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('frontend.shop.category', $product->category->slug) }}" class="text-decoration-none text-muted">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-5 mb-5">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                @if($product->featuredImage)
                    <img src="{{ asset('storage/' . $product->featuredImage->file_path) }}" alt="{{ $product->featuredImage->alt_text ?: $product->name }}" width="800" height="600" class="w-100" style="max-height: 450px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 400px;">
                        <i class="fa-solid fa-leaf fa-4x"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <span class="badge bg-success-subtle text-success border border-success mb-2">{{ $product->category ? $product->category->name : 'Plant' }}</span>
            <h1 class="display-6 fw-bold text-dark mb-2">{{ $product->name }}</h1>
            <div class="d-flex align-items-center mb-3">
                <span class="text-warning me-2">
                    <i class="fa-solid fa-star"></i> {{ $product->average_rating }}
                </span>
                <span class="text-muted small">({{ $product->review_count }} reviews)</span>
                <span class="mx-2 text-muted">•</span>
                <span class="small text-muted">SKU: <code>{{ $product->sku }}</code></span>
            </div>

            <div class="h3 fw-bold text-success mb-3">
                Rs. {{ number_format($product->price, 0) }}
                @if($product->compare_price)
                    <del class="text-muted fs-6 ms-2">Rs. {{ number_format($product->compare_price, 0) }}</del>
                @endif
            </div>

            <p class="text-secondary mb-4">{{ $product->short_description ?: Str::limit(strip_tags($product->description), 150) }}</p>

            <form action="{{ route('frontend.cart.add') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="d-flex gap-3">
                    <div style="width: 100px;">
                        <input type="number" name="quantity" class="form-control form-control-lg text-center" value="1" min="1" max="{{ $product->stock_quantity }}">
                    </div>
                    <button type="submit" class="btn btn-success btn-lg px-4 flex-grow-1" {{ $product->stock_status->value === 'out_of_stock' ? 'disabled' : '' }}>
                        <i class="fa-solid fa-cart-plus me-2"></i> {{ $product->stock_status->value === 'out_of_stock' ? 'Out of Stock' : 'Add to Cart' }}
                    </button>
                </div>
            </form>

            @if($product->plant)
                <div class="card border-0 bg-success-subtle p-3 rounded-3 mb-4">
                    <h6 class="fw-bold text-success mb-2"><i class="fa-solid fa-seedling me-2"></i>Plant Encyclopedia Match</h6>
                    <p class="small text-dark mb-2">This product is linked to <strong>{{ $product->plant->name }}</strong> (<em>{{ $product->plant->botanical_name }}</em>).</p>
                    <a href="{{ route('plants.show', $product->plant->slug) }}" class="btn btn-sm btn-success align-self-start">View Plant Care Guide &rarr;</a>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-header bg-white border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">Description</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">Reviews ({{ $product->review_count }})</button>
                </li>
            </ul>
        </div>
        <div class="card-body p-4">
            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="desc" role="tabpanel">
                    {!! nl2br(e($product->description)) !!}
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <h5 class="fw-bold mb-4">Customer Reviews</h5>

                    @auth
                        <form action="{{ route('frontend.products.reviews.store', $product) }}" method="POST" class="mb-4 p-3 bg-light rounded-3">
                            @csrf
                            <h6 class="fw-bold mb-2">Write a Review</h6>
                            <div class="mb-3">
                                <label class="form-label small">Rating</label>
                                <select name="rating" class="form-select form-select-sm" style="max-width: 150px;">
                                    <option value="5">5 Stars - Excellent</option>
                                    <option value="4">4 Stars - Good</option>
                                    <option value="3">3 Stars - Average</option>
                                    <option value="2">2 Stars - Poor</option>
                                    <option value="1">1 Star - Terrible</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="title" class="form-control form-control-sm" placeholder="Review Title">
                            </div>
                            <div class="mb-3">
                                <textarea name="review" class="form-control form-control-sm" rows="3" placeholder="Write your review experience..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-success">Submit Review</button>
                        </form>
                    @else
                        <p class="text-muted">Please <a href="{{ route('login') }}" class="text-success fw-bold">log in</a> to write a review.</p>
                    @endauth

                    <div class="mt-4">
                        @forelse($product->reviews as $rev)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <strong class="text-dark">{{ $rev->user ? $rev->user->name : 'Customer' }}</strong>
                                    <small class="text-muted">{{ $rev->created_at->format('M d, Y') }}</small>
                                </div>
                                <div class="text-warning small mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $rev->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                                @if($rev->title)<h6 class="mb-1 text-dark font-weight-bold">{{ $rev->title }}</h6>@endif
                                <p class="text-secondary small mb-0">{{ $rev->review }}</p>
                            </div>
                        @empty
                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
