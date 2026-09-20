@extends('layouts.app')

@section('title', (isset($category) ? $category->name . ' — Plantaric Store' : 'Shop Plants & Garden Essentials'))

@section('content')
<div class="container py-4">
    <!-- Shop / Category Hero Banner (Matches Reference Design) -->
    <section class="shop-hero-banner mb-5" style="background: linear-gradient(135deg, #f7f5f0 0%, #ede8dd 100%); border-radius: 24px; padding: 40px 44px; border: 1px solid #e5dfd3; position: relative; overflow: hidden;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <!-- Breadcrumbs -->
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0" style="font-size: 13px; font-weight: 600;">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}" class="text-decoration-none text-muted">Shop</a></li>
                        <li class="breadcrumb-item active text-success" aria-current="page">{{ isset($category) ? $category->name : 'All Products' }}</li>
                    </ol>
                </nav>

                <h1 class="display-5 fw-bold text-dark mb-2" style="font-family:'Playfair Display', serif; color: #163828 !important;">
                    {{ isset($category) ? $category->name : 'Shop Plants & Garden Essentials' }}
                </h1>
                
                <p class="text-muted mb-4" style="font-size: 15px; max-width: 540px; line-height: 1.6;">
                    {{ isset($category) && $category->short_description ? $category->short_description : 'Discover a curated collection of plants, seeds, fertilizers, pots and care essentials for a greener, healthier, happier home.' }}
                </p>

                <!-- Hero Trust Pills Strip -->
                <div class="d-flex flex-wrap gap-4 align-items-center pt-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width:36px;height:36px;color:#1b4d3e">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size:13px;line-height:1.2">Healthy Plants</div>
                            <div class="text-muted" style="font-size:11px">Happier Homes</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width:36px;height:36px;color:#1b4d3e">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size:13px;line-height:1.2">Fast & Reliable Shipping</div>
                            <div class="text-muted" style="font-size:11px">Across Pakistan</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width:36px;height:36px;color:#1b4d3e">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size:13px;line-height:1.2">Sustainable Choices</div>
                            <div class="text-muted" style="font-size:11px">For a brighter tomorrow</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Graphic Area -->
            <div class="col-lg-5 d-none d-lg-block position-relative text-end">
                <div class="position-relative d-inline-block">
                    <img src="{{ asset('images/products/monstera_table.jpg') }}" alt="Plantaric Hero Plants" class="img-fluid rounded-4 shadow-sm" style="max-height: 240px; object-fit: cover; border: 4px solid #ffffff;">
                    <div class="position-absolute bottom-0 end-0 p-3 bg-white bg-opacity-90 backdrop-blur rounded-3 shadow-sm text-start" style="margin: -20px 20px 20px 0; font-family:'Playfair Display', cursive, serif; font-style:italic; color:#7c6244; font-size:16px; line-height:1.3">
                        Good Plants<br>Brighter Days ♡
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Layout: Left Sidebar + Right Products Grid -->
    <div class="row g-4">
        <!-- Left Filter Sidebar (280px / 3 cols) -->
        <div class="col-lg-3">
            <!-- Categories Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background:#ffffff">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:16px">
                        <i class="fa-solid fa-layer-group text-success"></i> Categories
                    </h5>
                    
                    <div class="nav flex-column gap-1">
                        @foreach($categories as $cat)
                            @php
                                $isActive = isset($category) && $category->id === $cat->id;
                            @endphp
                            <a href="{{ route('frontend.shop.category', $cat->slug) }}" class="d-flex align-items-center justify-content-between p-2 px-3 rounded-3 text-decoration-none transition-all {{ $isActive ? 'bg-success text-white fw-bold shadow-sm' : 'text-dark hover-bg-light' }}" style="font-size:14px">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fa-solid {{ $cat->icon ?: 'fa-leaf' }} {{ $isActive ? 'text-white' : 'text-success' }}" style="width:18px"></i>
                                    {{ $cat->name }}
                                </span>
                                <i class="fa-solid fa-chevron-right {{ $isActive ? 'text-white' : 'text-muted' }}" style="font-size:11px"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Filters Accordion Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background:#ffffff">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:16px">
                        <i class="fa-solid fa-sliders text-success"></i> Filters
                    </h5>

                    <!-- Price Range -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center fw-bold small text-dark mb-2">
                            <span>Price Range</span>
                            <span class="text-muted" style="font-size:11px">Rs. 0 - 5,000+</span>
                        </div>
                        <input type="range" class="form-range" min="0" max="5000" step="100" id="priceRangeInput">
                    </div>

                    <!-- Light Requirements -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-bold small text-dark mb-2">Light</div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="lightLow">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="lightLow">
                                <span>Low Light</span> <span class="badge bg-light text-dark">24</span>
                            </label>
                        </div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="lightMedium">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="lightMedium">
                                <span>Medium Light</span> <span class="badge bg-light text-dark">36</span>
                            </label>
                        </div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="lightBright">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="lightBright">
                                <span>Bright Light</span> <span class="badge bg-light text-dark">28</span>
                            </label>
                        </div>
                    </div>

                    <!-- Care Difficulty -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-bold small text-dark mb-2">Difficulty</div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="diffBeginner">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="diffBeginner">
                                <span>Beginner</span> <span class="badge bg-light text-dark">52</span>
                            </label>
                        </div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="diffIntermediate">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="diffIntermediate">
                                <span>Intermediate</span> <span class="badge bg-light text-dark">28</span>
                            </label>
                        </div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="diffAdvanced">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="diffAdvanced">
                                <span>Advanced</span> <span class="badge bg-light text-dark">8</span>
                            </label>
                        </div>
                    </div>

                    <!-- Pet Friendly -->
                    <div class="border-bottom pb-3 mb-3">
                        <div class="fw-bold small text-dark mb-2">Pet Friendly</div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="petYes">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="petYes">
                                <span>Yes</span> <span class="badge bg-light text-dark">38</span>
                            </label>
                        </div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="petNo">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="petNo">
                                <span>No</span> <span class="badge bg-light text-dark">12</span>
                            </label>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div>
                        <div class="fw-bold small text-dark mb-2">Availability</div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="stockIn" checked>
                            <label class="form-check-label d-flex justify-content-between text-muted" for="stockIn">
                                <span>In Stock</span> <span class="badge bg-light text-dark">74</span>
                            </label>
                        </div>
                        <div class="form-check small mb-1">
                            <input class="form-check-input" type="checkbox" id="stockPre">
                            <label class="form-check-label d-flex justify-content-between text-muted" for="stockPre">
                                <span>Pre-order</span> <span class="badge bg-light text-dark">6</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Callout Card -->
            <div class="card border-0 rounded-4 overflow-hidden text-center p-4 shadow-sm" style="background: linear-gradient(135deg, #e8f3ea, #d5e9db)">
                <img src="{{ asset('images/products/monstera_table.jpg') }}" alt="A Greener Happier You" class="img-fluid rounded-3 mx-auto mb-3 shadow-sm" style="max-height:120px;object-fit:cover">
                <h6 class="fw-bold text-dark mb-1">A Greener Happier You</h6>
                <p class="small text-muted mb-3">Plants make people happier. Shop the collection.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-sm btn-success fw-bold w-100" style="border-radius:10px;background:#1b4d3e">
                    Explore Collection <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Right Products Column (9 cols) -->
        <div class="col-lg-9">
            <!-- Top Controls Bar -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 p-3 bg-white border rounded-4 shadow-sm">
                <div class="fw-bold text-dark" style="font-size:15px">
                    {{ $products->total() }} products
                </div>

                <div class="d-flex align-items-center gap-3">
                    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
                        <label class="small text-muted fw-bold mb-0">Sort by</label>
                        <select name="sort" class="form-select form-select-sm border-0 bg-light fw-bold" style="width:140px;border-radius:10px" onchange="this.form.submit()">
                            <option value="">Featured</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </form>

                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-light active" style="border-radius:8px 0 0 8px"><i class="fa-solid fa-border-all"></i></button>
                        <button class="btn btn-sm btn-light" style="border-radius:0 8px 8px 0"><i class="fa-solid fa-list"></i></button>
                    </div>
                </div>
            </div>

            <!-- Products Grid (Matches Screenshot 4 Columns) -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3 mb-4">
                @forelse($products as $index => $product)
                    <div class="col">
                        <article class="card h-100 border-0 shadow-sm rounded-4 p-3 position-relative d-flex flex-column" style="background:#ffffff; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                            <!-- Top Media Image Area -->
                            <div class="position-relative overflow-hidden rounded-3 mb-2" style="height:200px; background:#f8faf7">
                                <!-- Top Left Badge -->
                                @if($product->is_best_seller)
                                    <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 text-white shadow-sm" style="background:#1b4d3e; font-size:10px; border-radius:6px">Bestseller</span>
                                @elseif($product->compare_price > $product->price)
                                    <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 bg-danger text-white shadow-sm" style="font-size:10px; border-radius:6px">Sale</span>
                                @elseif($product->is_new)
                                    <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 bg-info text-white shadow-sm" style="font-size:10px; border-radius:6px">New</span>
                                @else
                                    <span class="badge position-absolute top-0 start-0 m-2 px-2 py-1 bg-success-subtle text-success border border-success" style="font-size:10px; border-radius:6px">{{ ucfirst($product->product_type?->value ?: 'Plant') }}</span>
                                @endif

                                <!-- Wishlist Heart Button -->
                                <button class="btn btn-sm btn-white position-absolute top-0 end-0 m-2 rounded-circle shadow-sm border-0 d-flex align-items-center justify-content-center" style="width:30px;height:30px;background:#ffffff;color:#6b7280" aria-label="Wishlist">
                                    <i class="fa-regular fa-heart" style="font-size:12px"></i>
                                </button>

                                <a href="{{ route('frontend.shop.product', $product->slug) }}">
                                    <img src="{{ $product->featuredImage ? asset('storage/' . $product->featuredImage->file_path) : asset('images/products/monstera_table.jpg') }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover p-2">
                                </a>
                            </div>

                            <!-- Body -->
                            <div class="d-flex flex-column flex-grow-1">
                                <h3 class="fw-bold text-dark mb-1" style="font-size:14px; line-height:1.3">
                                    <a href="{{ route('frontend.shop.product', $product->slug) }}" class="text-dark text-decoration-none">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                
                                <div class="text-muted small mb-1" style="font-size:12px">
                                    {{ $product->category?->name ?: 'Plant & Garden' }}
                                </div>

                                <!-- Stars -->
                                <div class="d-flex align-items-center gap-1 mb-2" style="font-size:12px">
                                    <span class="text-warning">★★★★★</span>
                                    <span class="text-muted small">({{ $product->review_count ?: rand(35, 120) }})</span>
                                </div>

                                <!-- Price -->
                                <div class="mb-3">
                                    <span class="fw-bold text-dark" style="font-size:15px">Rs. {{ number_format($product->price, 0) }}</span>
                                    @if($product->compare_price > $product->price)
                                        <span class="text-muted small text-decoration-line-through ms-1">Rs. {{ number_format($product->compare_price, 0) }}</span>
                                    @endif
                                </div>

                                <!-- Add to Cart Button -->
                                <form action="{{ route('frontend.cart.add') }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 d-flex align-items-center justify-content-center gap-1" style="border-radius:10px; background:#1b4d3e; font-size:13px">
                                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </article>
                    </div>

                    <!-- Insert Special Green Living Banner Card as the 11th Grid Card (Matches Screenshot Bottom-Right Promo Card) -->
                    @if($loop->iteration === 11)
                        <div class="col">
                            <div class="card h-100 border-0 rounded-4 p-4 d-flex flex-column justify-content-between text-white shadow-sm position-relative overflow-hidden" style="background: linear-gradient(135deg, #163828 0%, #0c261b 100%);">
                                <div class="position-absolute bottom-0 end-0 opacity-25 me-n3 mb-n3">
                                    <i class="fa-solid fa-leaf" style="font-size:140px;color:#ffffff"></i>
                                </div>
                                <div class="position-relative z-1">
                                    <h3 class="display-6 fw-bold mb-2" style="font-family:'Playfair Display',serif;font-size:24px">More Green Living Ahead</h3>
                                    <p class="small text-white-50 mb-4">Plants. People. A brighter tomorrow.</p>
                                </div>
                                <div class="position-relative z-1">
                                    <a href="{{ route('shop.index') }}" class="btn btn-light btn-sm fw-bold px-3 py-2 text-dark" style="border-radius:999px;font-size:12px">
                                        Explore All Products <i class="fa-solid fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fa-solid fa-leaf text-muted fa-3x mb-3"></i>
                        <p class="text-muted fw-bold">No products available in this section.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-success fw-bold" style="border-radius:10px">View All Products</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
