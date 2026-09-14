@extends('layouts.app')

@section('title', setting('seo_title', 'Plantaric — Agriculture, Plants & Botanical Care'))
@section('meta_description', setting('seo_description', 'Discover plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert growing advice.'))

@section('content')
    <section class="home-hero">
      <div class="container home-hero-container">
        <div class="home-hero-layout">
          <!-- Left Content Column -->
          <div class="home-hero-copy">
            <div class="home-hero-eyebrow">
              <i class="fa-solid fa-leaf"></i> GREENER HOMES, HAPPIER LIVES
            </div>

            <h1 class="home-hero-title">
              Bring Nature<br>
              <span class="title-accent">Home</span> <span class="title-leaf"><i class="fa-solid fa-leaf"></i></span>
            </h1>

            <p class="home-hero-desc">
              Shop healthy plants, discover trusted nurseries, and get expert advice to grow a greener, healthier tomorrow.
            </p>

            <div class="home-hero-actions">
              <a href="{{ route('shop.index') }}" class="home-btn-primary">
                Shop Plants <i class="fa-solid fa-arrow-right"></i>
              </a>
              <a href="{{ route('guides.index') }}" class="home-btn-outline">
                <i class="fa-solid fa-book-open"></i> Explore Guides
              </a>
            </div>

            <div class="home-hero-stats">
              <div class="home-stat-item">
                <div class="home-stat-icon">
                  <i class="fa-solid fa-leaf"></i>
                </div>
                <div class="home-stat-info">
                  <strong>1,200+</strong>
                  <span>Plant varieties</span>
                </div>
              </div>

              <div class="home-stat-divider"></div>

              <div class="home-stat-item">
                <div class="home-stat-icon">
                  <i class="fa-solid fa-users"></i>
                </div>
                <div class="home-stat-info">
                  <strong>80+</strong>
                  <span>Verified nurseries</span>
                </div>
              </div>

              <div class="home-stat-divider"></div>

              <div class="home-stat-item">
                <div class="home-stat-icon">
                  <i class="fa-solid fa-file-lines"></i>
                </div>
                <div class="home-stat-info">
                  <strong>500+</strong>
                  <span>Care guides</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Floating Feature Cards Column -->
          <div class="home-hero-features">
            <div class="hero-feature-card">
              <div class="feature-card-icon">
                <i class="fa-solid fa-leaf"></i>
              </div>
              <div class="feature-card-text">
                <strong>Healthy Plants</strong>
                <span>Quality assured</span>
              </div>
            </div>

            <div class="hero-feature-card">
              <div class="feature-card-icon">
                <i class="fa-solid fa-truck"></i>
              </div>
              <div class="feature-card-text">
                <strong>Fast Delivery</strong>
                <span>Across Pakistan</span>
              </div>
            </div>

            <div class="hero-feature-card">
              <div class="feature-card-icon">
                <i class="fa-solid fa-heart"></i>
              </div>
              <div class="feature-card-text">
                <strong>Expert Support</strong>
                <span>Always here to help</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="search-strip">
      <div class="container">
        <form action="{{ route('search.index') }}" method="GET" class="search-box">
          <label class="field">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input name="q" id="mainSearch" type="text" placeholder="Search plants, care guides, articles..." />
          </label>
          <label class="field">
            <i class="fa-solid fa-location-dot"></i>
            <select name="city">
              <option value="">Choose your city</option>
              <option>Lahore</option>
              <option>Karachi</option>
              <option>Islamabad</option>
              <option>Rawalpindi</option>
              <option>Faisalabad</option>
            </select>
          </label>
          <label class="field">
            <i class="fa-solid fa-layer-group"></i>
            <select name="category">
              <option value="">All categories</option>
              <option>Indoor Plants</option>
              <option>Outdoor Plants</option>
              <option>Seeds</option>
              <option>Fertilizers</option>
              <option>Plant Care</option>
            </select>
          </label>
          <button type="submit" class="btn" id="searchBtn">Explore <i class="fa-solid fa-arrow-right"></i></button>
        </form>
      </div>
    </section>

    <section class="section" id="plants">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Explore categories</span>
            <h2 style="margin-top:14px">Find your next green favorite.</h2>
          </div>
          <a class="link-arrow" href="{{ route('shop.index') }}">View all categories <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="category-grid">
          @foreach($categories as $category)
            <a class="category" href="{{ route('shop.index') }}">
              <div class="category-img"><img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="skeleton-img"></div>
              <h4>{{ $category['name'] }}</h4><span>{{ $category['count'] }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </section>

    <!-- About Us Section (Matches Reference Design) -->
    <section class="about-us-section" id="about">
      <!-- Decorative background grid lines -->
      <div class="about-bg-grid" aria-hidden="true">
        <div class="grid-line"><span class="line-bar bar-top"></span></div>
        <div class="grid-line"><span class="line-bar bar-bottom"></span></div>
        <div class="grid-line"><span class="line-bar bar-top-mid"></span></div>
        <div class="grid-line"><span class="line-bar bar-mid"></span></div>
        <div class="grid-line"><span class="line-bar bar-bottom-right"></span></div>
      </div>

      <!-- Soft light green semi-circle backdrop on left -->
      <div class="about-left-backdrop" aria-hidden="true"></div>

      <!-- Organic decorative swoosh curve -->
      <svg class="about-swoosh" viewBox="0 0 1000 500" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M 120,240 C 320,130 440,360 490,190 C 520,90 470,10 440,110 C 410,210 510,310 640,230 C 770,150 820,360 920,300" stroke="#e1ebd9" stroke-width="1.5" />
      </svg>

      <div class="container about-container">
        <div class="about-grid">
          <!-- Left area with full unbroken plant pot -->
          <div class="about-spacer">
            <div class="about-plant-wrap">
              <img src="{{ asset('images/about-plant.png') }}" alt="Snake plant in white pot" class="about-plant-img">
            </div>
          </div>

          <!-- Right content area -->
          <div class="about-content">
            <div class="about-title-row">
              <div class="about-vertical-tag">About Us</div>
              <h2 class="about-heading">
                Keep your<br>
                plants <span class="text-accent-green">alive</span>
              </h2>
            </div>

            <div class="about-text-body">
              <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before final copy is available.</p>
              <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document.</p>
            </div>

            <div class="about-action">
              <a href="{{ route('frontend.about') }}" class="btn-know-more">Know More</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom right floating leaves -->
      <div class="about-floating-leaves" aria-hidden="true">
        <img src="{{ asset('images/floating-leaves.png') }}" alt="Floating leaves decorative accent">
      </div>
    </section>

    <section class="section-sm">
      <div class="container">
        <div class="promo-grid">
          <article class="promo-card">
            <img src="https://images.unsplash.com/photo-1497250681960-ef046c08a56e?auto=format&fit=crop&w=1200&q=85" alt="Green indoor plant leaves" class="skeleton-img">
            <div class="promo-content">
              <span class="article-tag">Easy-care collection</span>
              <h3>Plants for beginners.</h3>
              <p>Low-maintenance greenery for homes, desks and busy schedules.</p>
              <a class="btn btn-light" href="{{ route('plants.index') }}">Shop easy-care plants</a>
            </div>
          </article>

          <article class="promo-card alt">
            <img src="https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?auto=format&fit=crop&w=1000&q=85" alt="Hands gardening outdoors" class="skeleton-img">
            <div class="promo-content">
              <span class="article-tag">Seasonal guide</span>
              <h3>What to plant this month?</h3>
              <p>Get a location-based planting calendar for your city.</p>
              <a class="btn btn-light" href="{{ route('guides.index') }}">Open care guides</a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="section" id="shop">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Trending now</span>
            <h2 style="margin-top:14px">Popular plants this week.</h2>
            <p>Healthy, nursery-grown plants selected for home and office spaces.</p>
          </div>
          <a class="link-arrow" href="{{ route('plants.index') }}">Shop all plants <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="product-grid">
          @foreach($trendingProducts as $product)
            <article class="product-card">
              <div class="product-media">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="skeleton-img">
                <span class="badge">{{ $product['badge'] }}</span>
                <button class="wish"><i class="fa-regular fa-heart"></i></button>
              </div>
              <div class="product-body">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <span class="care-pill care-pill-green"><i class="fa-solid fa-paw"></i> Pet Friendly</span>
                  <span class="care-pill care-pill-purple"><i class="fa-solid fa-seedling"></i> Easy Care</span>
                </div>
                <div class="rating">★★★★★ <span>({{ $product['reviews'] }})</span></div>
                <h3><a href="{{ route('plants.show', $product['slug']) }}" class="text-dark text-decoration-none">{{ $product['name'] }}</a></h3>
                <div class="product-meta"><span><i class="fa-solid fa-sun"></i> {{ $product['light'] }}</span><span><i class="fa-solid fa-droplet"></i> {{ $product['water'] }}</span></div>
                <div class="price-row">
                  <div class="price"><strong>{{ $product['price'] }}</strong></div>
                  <a href="{{ route('plants.show', $product['slug']) }}" class="btn btn-sm btn-outline-success" style="border-radius:10px">View Plant</a>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section-sm" id="problems">
      <div class="container">
        <div class="problem-wrap">
          <div class="problem-head">
            <div>
              <span class="eyebrow" style="background:rgba(255,255,255,.1);color:#dff2ca">Plant Doctor</span>
              <h2 style="margin-top:15px">What’s wrong with your plant?</h2>
            </div>
            <p>Select a plant problem to get instant symptoms, causes, and botanical treatments.</p>
          </div>

          <div class="problem-grid">
            @foreach($featuredProblems as $prob)
              <a href="{{ route('problems.show', $prob->slug) }}" class="problem-card text-decoration-none">
                <i class="fa-solid fa-user-doctor"></i><span>{{ $prob->name }}</span>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </section>

    <!-- Phase 3 Content: Plant Care Guides -->
    <section class="section" id="guides">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Learn & grow</span>
            <h2 style="margin-top:14px">Plant care guides people actually use.</h2>
            <p>Step-by-step botanical guides and care tutorials written by Plantaric horticulturists.</p>
          </div>
          <a class="link-arrow" href="{{ route('guides.index') }}">Browse all guides <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="row g-4">
          @foreach($featuredGuides as $guide)
            <div class="col-md-4">
              <article class="product-card h-100">
                <div class="product-media" style="height:200px">
                  <img src="{{ $guide->featuredImage ? asset('storage/' . $guide->featuredImage->file_path) : 'https://images.unsplash.com/photo-1545239705-1564e58b9e4a?auto=format&fit=crop&w=700&q=85' }}" alt="{{ $guide->title }}">
                  <span class="badge position-absolute top-0 start-0 m-3 bg-success text-white shadow-sm">Guide</span>
                </div>
                <div class="product-body d-flex flex-column">
                  <div class="small text-muted mb-2"><i class="fa-regular fa-clock me-1"></i> {{ $guide->reading_time ?: 5 }} min read</div>
                  <h3 class="fw-bold mb-2" style="font-size:18px"><a href="{{ route('guides.show', $guide->slug) }}" class="text-dark text-decoration-none">{{ $guide->title }}</a></h3>
                  <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($guide->excerpt ?: strip_tags($guide->content), 100) }}</p>
                  <a href="{{ route('guides.show', $guide->slug) }}" class="fw-bold text-success text-decoration-none mt-auto">Read Guide <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
              </article>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Phase 3 Content: Plant News -->
    <section class="section-sm" id="news">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Plant & gardening news</span>
            <h2 style="margin-top:14px">Fresh stories from the growing world.</h2>
          </div>
          <a class="link-arrow" href="{{ route('news.index') }}">View all news <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="news-grid">
          @foreach($latestNews as $newsItem)
            <article class="news-card">
              <img src="{{ $newsItem->featuredImage ? asset('storage/' . $newsItem->featuredImage->file_path) : 'https://images.unsplash.com/photo-1524486361537-8ad15938e1a3?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $newsItem->title }}" class="skeleton-img">
              <div class="news-body">
                <small>{{ $newsItem->category?->name ?: 'Industry News' }} &bull; {{ $newsItem->published_at ? $newsItem->published_at->format('M d, Y') : now()->format('M d, Y') }}</small>
                <h3><a href="{{ route('news.show', $newsItem->slug) }}" class="text-dark text-decoration-none">{{ $newsItem->title }}</a></h3>
                <p>{{ Str::limit($newsItem->excerpt ?: strip_tags($newsItem->content), 100) }}</p>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section-sm">
      <div class="container">
        <div class="newsletter">
          <div>
            <span class="eyebrow" style="background:rgba(255,255,255,.1);color:#e6f4df">Weekly plant notes</span>
            <h2 style="margin-top:14px">Grow smarter every week.</h2>
            <p>Seasonal tips, new plant guides, nursery discoveries and special shop offers in your inbox.</p>
          </div>
          <form class="subscribe" id="subscribeForm" action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf
            <input type="email" id="emailInput" name="email" placeholder="Enter your email address" required>
            <button type="submit">Join newsletter</button>
          </form>
        </div>
      </div>
    </section>
@endsection
