@extends('layouts.app')

@section('title', 'Plantora — Plants, Nurseries & Garden Care')
@section('meta_description', 'Discover plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert growing advice.')

@section('content')
    <section class="hero">
      <div class="container">
        <div class="hero-grid">
          <div class="hero-copy">
            <span class="eyebrow"><i class="fa-solid fa-sun"></i> Grow better, every season</span>
            <h1>Everything your plants need to <span>thrive.</span></h1>
            <p>Shop healthy plants, discover trusted nurseries, solve plant problems and learn how to grow with practical care guides made for your climate.</p>

            <div class="hero-actions">
              <a href="#shop" class="btn btn-primary">Shop Plants <i class="fa-solid fa-arrow-right"></i></a>
              <a href="#nurseries" class="btn btn-outline">Find Nearby Nurseries</a>
            </div>

            <div class="hero-stats">
              <div class="hero-stat"><strong>1,200+</strong><span>Plant varieties</span></div>
              <div class="hero-stat"><strong>80+</strong><span>Verified nurseries</span></div>
              <div class="hero-stat"><strong>500+</strong><span>Care guides</span></div>
            </div>
          </div>

          <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&w=1400&q=85" alt="Beautiful indoor plants in a bright interior">
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
        <div class="search-box">
          <label class="field">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input id="mainSearch" type="text" placeholder="Search plants, seeds, guides..." />
          </label>
          <label class="field">
            <i class="fa-solid fa-location-dot"></i>
            <select>
              <option>Choose your city</option>
              <option>Lahore</option>
              <option>Karachi</option>
              <option>Islamabad</option>
              <option>Rawalpindi</option>
              <option>Faisalabad</option>
            </select>
          </label>
          <label class="field">
            <i class="fa-solid fa-layer-group"></i>
            <select>
              <option>All categories</option>
              <option>Indoor Plants</option>
              <option>Outdoor Plants</option>
              <option>Seeds</option>
              <option>Fertilizers</option>
              <option>Plant Care</option>
            </select>
          </label>
          <button class="btn" id="searchBtn">Explore <i class="fa-solid fa-arrow-right"></i></button>
        </div>
      </div>
    </section>

    <section class="section" id="plants">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Explore categories</span>
            <h2 style="margin-top:14px">Find your next green favorite.</h2>
          </div>
          <a class="link-arrow" href="#">View all categories <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="category-grid">
          <a class="category" href="#">
            <div class="category-img"><img src="https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?auto=format&fit=crop&w=500&q=80" alt="Indoor plants"></div>
            <h4>Indoor Plants</h4><span>184 products</span>
          </a>
          <a class="category" href="#">
            <div class="category-img"><img src="https://images.unsplash.com/photo-1591857177580-dc82b9ac4e1e?auto=format&fit=crop&w=500&q=80" alt="Outdoor plants"></div>
            <h4>Outdoor Plants</h4><span>226 products</span>
          </a>
          <a class="category" href="#">
            <div class="category-img"><img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=500&q=80" alt="Flowering plants"></div>
            <h4>Flowering</h4><span>96 products</span>
          </a>
          <a class="category" href="#">
            <div class="category-img"><img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=500&q=80" alt="Vegetable seeds"></div>
            <h4>Seeds</h4><span>312 products</span>
          </a>
          <a class="category" href="#">
            <div class="category-img"><img src="https://images.unsplash.com/photo-1599685315640-9ceab2f581ca?auto=format&fit=crop&w=500&q=80" alt="Plant pots"></div>
            <h4>Pots & Planters</h4><span>124 products</span>
          </a>
          <a class="category" href="#">
            <div class="category-img"><img src="https://images.unsplash.com/photo-1604762512526-b7ce049b5764?auto=format&fit=crop&w=500&q=80" alt="Garden tools"></div>
            <h4>Garden Care</h4><span>168 products</span>
          </a>
        </div>
      </div>
    </section>

    <section class="section-sm">
      <div class="container">
        <div class="promo-grid">
          <article class="promo-card">
            <img src="https://images.unsplash.com/photo-1497250681960-ef046c08a56e?auto=format&fit=crop&w=1200&q=85" alt="Green indoor plant leaves">
            <div class="promo-content">
              <span class="article-tag">Easy-care collection</span>
              <h3>Plants for beginners.</h3>
              <p>Low-maintenance greenery for homes, desks and busy schedules.</p>
              <a class="btn btn-light" href="#">Shop easy-care plants</a>
            </div>
          </article>

          <article class="promo-card alt">
            <img src="https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?auto=format&fit=crop&w=1000&q=85" alt="Hands gardening outdoors">
            <div class="promo-content">
              <span class="article-tag">Seasonal guide</span>
              <h3>What to plant this month?</h3>
              <p>Get a location-based planting calendar for your city.</p>
              <a class="btn btn-light" href="#calendar">Open planting calendar</a>
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
          <a class="link-arrow" href="#">Shop all plants <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="product-grid">
          <article class="product-card">
            <div class="product-media">
              <img src="https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85" alt="Monstera plant">
              <span class="badge">Best seller</span>
              <button class="wish"><i class="fa-regular fa-heart"></i></button>
            </div>
            <div class="product-body">
              <div class="rating">★★★★★ <span>(128)</span></div>
              <h3>Monstera Deliciosa</h3>
              <div class="product-meta"><span><i class="fa-solid fa-sun"></i> Medium light</span><span><i class="fa-solid fa-droplet"></i> Weekly</span></div>
              <div class="price-row">
                <div class="price"><strong>Rs. 2,450</strong><del>Rs. 2,900</del></div>
                <button class="add-btn" data-product="Monstera Deliciosa"><i class="fa-solid fa-plus"></i></button>
              </div>
            </div>
          </article>

          <article class="product-card">
            <div class="product-media">
              <img src="https://images.unsplash.com/photo-1593482892290-f54927ae2b7f?auto=format&fit=crop&w=700&q=85" alt="Snake plant">
              <span class="badge">Low light</span>
              <button class="wish"><i class="fa-regular fa-heart"></i></button>
            </div>
            <div class="product-body">
              <div class="rating">★★★★★ <span>(96)</span></div>
              <h3>Snake Plant</h3>
              <div class="product-meta"><span><i class="fa-solid fa-cloud-sun"></i> Low light</span><span><i class="fa-solid fa-droplet"></i> 2–3 weeks</span></div>
              <div class="price-row">
                <div class="price"><strong>Rs. 1,650</strong></div>
                <button class="add-btn" data-product="Snake Plant"><i class="fa-solid fa-plus"></i></button>
              </div>
            </div>
          </article>

          <article class="product-card">
            <div class="product-media">
              <img src="https://images.unsplash.com/photo-1601985705806-5b9a71f6004f?auto=format&fit=crop&w=700&q=85" alt="Fiddle leaf fig">
              <span class="badge">Statement plant</span>
              <button class="wish"><i class="fa-regular fa-heart"></i></button>
            </div>
            <div class="product-body">
              <div class="rating">★★★★☆ <span>(74)</span></div>
              <h3>Fiddle Leaf Fig</h3>
              <div class="product-meta"><span><i class="fa-solid fa-sun"></i> Bright light</span><span><i class="fa-solid fa-droplet"></i> Weekly</span></div>
              <div class="price-row">
                <div class="price"><strong>Rs. 3,850</strong></div>
                <button class="add-btn" data-product="Fiddle Leaf Fig"><i class="fa-solid fa-plus"></i></button>
              </div>
            </div>
          </article>

          <article class="product-card">
            <div class="product-media">
              <img src="https://images.unsplash.com/photo-1597055181300-e3633a207517?auto=format&fit=crop&w=700&q=85" alt="Peace lily plant">
              <span class="badge">Air purifying</span>
              <button class="wish"><i class="fa-regular fa-heart"></i></button>
            </div>
            <div class="product-body">
              <div class="rating">★★★★★ <span>(110)</span></div>
              <h3>Peace Lily</h3>
              <div class="product-meta"><span><i class="fa-solid fa-cloud-sun"></i> Indirect</span><span><i class="fa-solid fa-droplet"></i> Weekly</span></div>
              <div class="price-row">
                <div class="price"><strong>Rs. 1,950</strong></div>
                <button class="add-btn" data-product="Peace Lily"><i class="fa-solid fa-plus"></i></button>
              </div>
            </div>
          </article>
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
            <p>Choose a symptom to get possible causes, care steps and recommended treatment products. Later, this can connect to an AI photo diagnosis feature.</p>
          </div>

          <div class="problem-grid">
            <div class="problem-card"><i class="fa-solid fa-leaf"></i><span>Yellow Leaves</span></div>
            <div class="problem-card"><i class="fa-solid fa-temperature-arrow-up"></i><span>Brown Tips</span></div>
            <div class="problem-card"><i class="fa-solid fa-bug"></i><span>Insects</span></div>
            <div class="problem-card"><i class="fa-solid fa-droplet-slash"></i><span>Wilting</span></div>
            <div class="problem-card"><i class="fa-solid fa-bacteria"></i><span>Leaf Spots</span></div>
            <div class="problem-card"><i class="fa-solid fa-seedling"></i><span>Slow Growth</span></div>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="nurseries">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Local discovery</span>
            <h2 style="margin-top:14px">Trusted nurseries near you.</h2>
            <p>Browse verified plant sellers, compare selections, delivery areas and ratings.</p>
          </div>
        </div>

        <div class="nursery-grid">
          <div class="nursery-image">
            <img src="https://images.unsplash.com/photo-1592150621744-aca64f48394a?auto=format&fit=crop&w=1200&q=85" alt="Plant nursery">
            <div class="map-chip"><strong><i class="fa-solid fa-location-dot"></i> Lahore</strong><br><small>24 verified nurseries nearby</small></div>
          </div>

          <div class="nursery-panel">
            <span class="eyebrow">Top rated nearby</span>
            <h3 style="font-size:30px;margin-top:18px">Discover local plant experts.</h3>
            <p>Visit in person, order online or request local delivery from trusted nurseries in your city.</p>

            <div class="nursery-list">
              <div class="nursery-item">
                <div class="nursery-logo"><img src="https://images.unsplash.com/photo-1558904541-efa843a96f01?auto=format&fit=crop&w=300&q=80" alt=""></div>
                <div><h4>Green Roots Nursery <i class="fa-solid fa-circle-check verified"></i></h4><small>Indoor plants · Pots · Delivery</small></div>
                <span class="distance">2.4 km</span>
              </div>
              <div class="nursery-item">
                <div class="nursery-logo"><img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=300&q=80" alt=""></div>
                <div><h4>Botanical House <i class="fa-solid fa-circle-check verified"></i></h4><small>Rare plants · Seeds · Soil mixes</small></div>
                <span class="distance">4.1 km</span>
              </div>
              <div class="nursery-item">
                <div class="nursery-logo"><img src="https://images.unsplash.com/photo-1584479898061-15742e14f50d?auto=format&fit=crop&w=300&q=80" alt=""></div>
                <div><h4>Urban Leaf Nursery <i class="fa-solid fa-circle-check verified"></i></h4><small>Balcony plants · Herbs · Tools</small></div>
                <span class="distance">5.8 km</span>
              </div>
            </div>

            <a href="#" class="btn" style="background:var(--green-900);color:white">Explore all nurseries <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </section>

    <section class="section-sm" id="calendar">
      <div class="container">
        <div class="calendar-card">
          <div>
            <span class="eyebrow">Pakistan planting calendar</span>
            <h2 style="margin-top:14px">Know what to plant, and when.</h2>
            <p>Select your city and month to see suitable vegetables, herbs, flowers and seasonal planting recommendations.</p>
            <a class="btn" href="#" style="background:var(--green-900);color:white;margin-top:14px">Open full calendar <i class="fa-solid fa-calendar-days"></i></a>
          </div>

          <div class="calendar-ui">
            <div class="calendar-ui-top">
              <div><strong>Lahore</strong><br><small style="color:var(--muted)">Recommended for your climate</small></div>
              <span class="month-badge">September</span>
            </div>
            <div class="plant-row"><div><strong>Spinach</strong><br><span>Direct sow · 35–45 days</span></div><strong>Great</strong></div>
            <div class="plant-row"><div><strong>Coriander</strong><br><span>Direct sow · 25–35 days</span></div><strong>Great</strong></div>
            <div class="plant-row"><div><strong>Broccoli</strong><br><span>Seed tray · Transplant later</span></div><strong>Good</strong></div>
            <div class="plant-row"><div><strong>Petunia</strong><br><span>Flowering · Full sun</span></div><strong>Great</strong></div>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="guides">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Learn & grow</span>
            <h2 style="margin-top:14px">Plant care guides people actually use.</h2>
            <p>Evergreen articles designed for search traffic, helpful answers and product discovery.</p>
          </div>
          <a class="link-arrow" href="#">Browse all guides <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="content-grid">
          <article class="featured-article">
            <img src="https://images.unsplash.com/photo-1545239705-1564e58b9e4a?auto=format&fit=crop&w=1200&q=85" alt="Monstera leaves">
            <div class="article-copy">
              <span class="article-tag">Plant Care</span>
              <h3>Why are my Monstera leaves turning yellow?</h3>
              <p>Understand overwatering, drainage, light and nutrient problems—and what to do next.</p>
              <a class="btn btn-light" href="#">Read guide <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </article>

          <div class="small-articles">
            <article class="small-article">
              <img src="https://images.unsplash.com/photo-1491147334573-44cbb4602074?auto=format&fit=crop&w=400&q=80" alt="">
              <div><small>Indoor Plants</small><h4>12 low-light plants for apartments</h4><p>Easy greenery for darker spaces and busy schedules.</p></div>
            </article>
            <article class="small-article">
              <img src="https://images.unsplash.com/photo-1591857177580-dc82b9ac4e1e?auto=format&fit=crop&w=400&q=80" alt="">
              <div><small>Seasonal</small><h4>Best plants for Lahore summer heat</h4><p>Heat-tolerant varieties that survive intense weather.</p></div>
            </article>
            <article class="small-article">
              <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=400&q=80" alt="">
              <div><small>Gardening</small><h4>How to start a balcony garden</h4><p>Choose containers, soil, sunlight and starter plants.</p></div>
            </article>
          </div>
        </div>
      </div>
    </section>

    <section class="section-sm" id="news">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow">Plant & gardening news</span>
            <h2 style="margin-top:14px">Fresh stories from the growing world.</h2>
          </div>
          <a class="link-arrow" href="#">View all news <i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <div class="news-grid">
          <article class="news-card">
            <img src="https://images.unsplash.com/photo-1524486361537-8ad15938e1a3?auto=format&fit=crop&w=800&q=80" alt="">
            <div class="news-body"><small>Urban Gardening · 5 min read</small><h3>Why compact city gardens are growing in popularity</h3><p>Balconies, rooftops and small spaces are changing how urban households grow food and greenery.</p></div>
          </article>
          <article class="news-card">
            <img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?auto=format&fit=crop&w=800&q=80" alt="">
            <div class="news-body"><small>Plant Science · 4 min read</small><h3>Smarter irrigation is reshaping home gardening</h3><p>New sensors and automation tools are making watering more precise and less wasteful.</p></div>
          </article>
          <article class="news-card">
            <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=800&q=80" alt="">
            <div class="news-body"><small>Nursery Market · 6 min read</small><h3>Local nurseries are moving more inventory online</h3><p>Digital storefronts and delivery are creating new opportunities for independent plant sellers.</p></div>
          </article>
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
          <form class="subscribe" id="subscribeForm">
            <input type="email" id="emailInput" placeholder="Enter your email address" required>
            <button type="submit">Join newsletter</button>
          </form>
        </div>
      </div>
    </section>
@endsection
