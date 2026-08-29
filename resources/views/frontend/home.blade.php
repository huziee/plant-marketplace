@extends('layouts.app')

@section('title', setting('seo_title', 'Plantora — Plants, Nurseries & Garden Care'))
@section('meta_description', setting('seo_description', 'Discover plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert growing advice.'))

@section('content')
    <section class="hero">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-copy">
            <span class="eyebrow"><i class="fa-solid fa-sun"></i> Grow better, every season</span>
            <h1>Everything your plants need to <span>thrive.</span></h1>
            <p>Shop healthy plants, discover trusted nurseries, solve plant problems and learn how to grow with practical care guides made for your climate.</p>

            <div class="hero-actions">
              <a href="{{ route('shop.index') }}" class="btn btn-primary">Shop Plants <i class="fa-solid fa-arrow-right"></i></a>
              <a href="#nurseries" class="btn btn-outline">Find Nearby Nurseries</a>
            </div>

            <div class="hero-stats">
              <div class="hero-stat"><strong>1,200+</strong><span>Plant varieties</span></div>
              <div class="hero-stat"><strong>80+</strong><span>Verified nurseries</span></div>
              <div class="hero-stat"><strong>500+</strong><span>Care guides</span></div>
            </div>
          </div>

          <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&w=1400&q=85" alt="Beautiful indoor plants in a bright interior" class="skeleton-img">
            <div class="floating-card one">
              <span class="float-icon"><i class="fa-solid fa-droplet"></i></span>
              <div><strong>Smart care reminders</strong><span>Never miss a watering day</span></div>
            </div>
            <div class="floating-card two">
              <span class="float-icon"><i class="fa-solid fa-location-dot"></i></span>
              <div><strong>Nurseries near you</strong><span>Verified local sellers</span></div>
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
            <p>Step-by-step botanical guides and care tutorials written by Plantora horticulturists.</p>
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
