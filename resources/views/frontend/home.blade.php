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
              Shop healthy plants, discover expert botanical advice, and explore care articles to grow a greener, healthier tomorrow.
            </p>

            <div class="home-hero-actions">
              <a href="{{ route('shop.index') }}" class="home-btn-primary">
                Shop Plants <i class="fa-solid fa-arrow-right"></i>
              </a>
              <a href="{{ route('articles.index') }}" class="home-btn-outline">
                <i class="fa-solid fa-newspaper"></i> Read Articles
              </a>
            </div>

            <div class="home-hero-stats">
              <div class="home-stat-item">
                <div class="home-stat-icon">
                  <i class="fa-solid fa-leaf"></i>
                </div>
                <div class="home-stat-info">
                  <strong>{{ !empty($plantsCount) ? number_format($plantsCount) : '1,200+' }}</strong>
                  <span>Plant varieties</span>
                </div>
              </div>

              <div class="home-stat-divider"></div>

              <div class="home-stat-item">
                <div class="home-stat-icon">
                  <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="home-stat-info">
                  <strong>{{ !empty($categoriesCount) ? number_format($categoriesCount) : '24+' }}</strong>
                  <span>Plant categories</span>
                </div>
              </div>

              <div class="home-stat-divider"></div>

              <div class="home-stat-item">
                <div class="home-stat-icon">
                  <i class="fa-solid fa-newspaper"></i>
                </div>
                <div class="home-stat-info">
                  <strong>{{ !empty($articlesCount) ? number_format($articlesCount) : '150+' }}</strong>
                  <span>Botanical articles</span>
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
            <a class="category" href="{{ route('frontend.shop.category', $category['slug']) }}">
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
              <img src="{{ asset('/images/hero/about-sec.png') }}" alt="Snake plant in white pot" class="about-plant-img">
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
              <p>Plantaric is your all-in-one botanical marketplace and digital plant care ecosystem. We connect plant lovers, home gardeners, and horticulture experts with healthy plants, curated shop supplies, and comprehensive care guides.</p>
              <p>Whether you are nurturing your first indoor succulent or building a lush outdoor haven, our scientific encyclopedia, expert-written articles, and automated health tracking empower you to cultivate thriving green spaces with confidence.</p>
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
            <img src="{{ asset('images/home/promo_beginner.jpg') }}" alt="Green indoor plant leaves" class="skeleton-img">
            <div class="promo-content">
              <span class="article-tag">Easy-care collection</span>
              <h3>Plants for beginners.</h3>
              <p>Low-maintenance greenery for homes, desks and busy schedules.</p>
              <a class="btn btn-light" href="{{ route('plants.index') }}">Shop easy-care plants</a>
            </div>
          </article>

          <article class="promo-card alt">
            <img src="{{ asset('images/home/promo_articles.jpg') }}" alt="Hands gardening outdoors" class="skeleton-img">
            <div class="promo-content">
              <span class="article-tag">Botanical Science</span>
              <h3>Expert Plant Articles</h3>
              <p>Explore research-backed plant care, soil health, and botanical advice.</p>
              <a class="btn btn-light" href="{{ route('articles.index') }}">Read articles</a>
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
            <p>Healthy, premium plants selected for home and office spaces.</p>
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

    <!-- Phase 3 Content: Botanical Articles -->
    <section class="section" id="articles">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Learn & grow</span>
            <h2 style="margin-top:14px">Plant & botanical articles.</h2>
            <p>In-depth articles, botanical science, and expert care insights written by Plantaric horticulturists.</p>
          </div>
          <a class="link-arrow" href="{{ route('articles.index') }}">Browse all articles <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="row g-4">
          @foreach($featuredArticles as $article)
            <div class="col-md-4">
              <article class="product-card h-100">
                <div class="product-media" style="height:200px">
                  <img src="{{ $article->featuredImage ? asset('storage/' . $article->featuredImage->file_path) : asset('images/placeholders/plant_placeholder.jpg') }}" alt="{{ $article->title }}" class="w-100 h-100 object-fit-cover">
                  <span class="badge position-absolute top-0 start-0 m-3 bg-success text-white shadow-sm">Article</span>
                </div>
                <div class="product-body d-flex flex-column">
                  <div class="small text-muted mb-2"><i class="fa-regular fa-clock me-1"></i> {{ $article->reading_time ?: 5 }} min read</div>
                  <h3 class="fw-bold mb-2" style="font-size:18px"><a href="{{ route('articles.show', $article->slug) }}" class="text-dark text-decoration-none">{{ $article->title }}</a></h3>
                  <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($article->excerpt ?: strip_tags($article->content), 100) }}</p>
                  <a href="{{ route('articles.show', $article->slug) }}" class="fw-bold text-success text-decoration-none mt-auto">Read Article <i class="fa-solid fa-arrow-right ms-1"></i></a>
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
              <img src="{{ $newsItem->featuredImage ? asset('storage/' . $newsItem->featuredImage->file_path) : asset('images/placeholders/news_banner.jpg') }}" alt="{{ $newsItem->title }}" class="skeleton-img">
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
            <p>Seasonal tips, new plant articles, botanical discoveries and special shop offers in your inbox.</p>
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
