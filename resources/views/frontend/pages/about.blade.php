@extends('layouts.app')

@section('title', 'About Plantaric — Our Passion Grows With You')
@section('meta_description', 'At Plantaric, we believe plants have the power to make life better. Discover our mission, botanical encyclopedia, articles, marketplace, and community.')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
<style>
    /* Plantaric About Us Page - Custom Reference Match Styling */
    :root {
        --plantaric-dark: #123522;
        --plantaric-forest: #0f3822;
        --plantaric-green: #2d6a4f;
        --plantaric-light-bg: #f5f8f5;
        --plantaric-sage-bg: #eef4ee;
        --plantaric-accent-mint: #d8f3dc;
        --plantaric-pill-bg: #e8f5e9;
        --plantaric-heading-color: #1a2e22;
    }

    body {
        background-color: #ffffff;
        color: #4a5568;
        font-family: 'DM Sans', sans-serif;
    }

    .handwritten-text {
        font-family: 'Caveat', cursive;
        font-size: 1.85rem;
        color: #2d6a4f;
        line-height: 1.1;
    }

    .section-eyebrow-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #e8f5e9;
        color: #2d6a4f;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        padding: 0.35rem 0.9rem;
        border-radius: 50px;
        text-transform: uppercase;
        margin-bottom: 0.85rem;
    }

    .main-heading-serif {
        font-family: 'Playfair Display', Georgia, serif;
        font-weight: 700;
        color: var(--plantaric-heading-color);
        line-height: 1.2;
    }

    /* ----------------------------------------------------
       1. HERO SECTION
    ---------------------------------------------------- */
    .hero-about-wrapper {
        background: radial-gradient(circle at 80% 30%, #e2f0e4 0%, #f4f8f4 60%, #ffffff 100%);
        position: relative;
        padding: 2.5rem 0 4rem 0;
        overflow: hidden;
    }
    .hero-blob-bg {
        position: absolute;
        top: 0;
        right: 0;
        width: 55%;
        height: 100%;
        background: radial-gradient(circle, rgba(200, 230, 205, 0.45) 0%, rgba(245, 248, 245, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-monstera-img {
        max-width: 100%;
        height: auto;
        border-radius: 24px;
        filter: drop-shadow(0 20px 30px rgba(18, 53, 34, 0.12));
    }
    .hero-mini-feature {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .hero-mini-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #d8f3dc;
        color: #1b4332;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* ----------------------------------------------------
       2. OUR MISSION SECTION
    ---------------------------------------------------- */
    .mission-section {
        padding: 4.5rem 0;
    }
    .mission-img-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }
    .mission-img-card img {
        width: 100%;
        height: 380px;
        object-fit: cover;
    }
    .mission-overlay-badge {
        position: absolute;
        top: 50%;
        right: 1.5rem;
        transform: translateY(-50%);
        background: rgba(18, 53, 34, 0.78);
        backdrop-filter: blur(8px);
        color: #ffffff;
        padding: 1rem 1.5rem;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 600;
        text-align: right;
    }

    .stat-chip-card {
        background: #f4f8f4;
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e1ebe2;
    }
    .stat-chip-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #d8f3dc;
        color: #1b4332;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    /* ----------------------------------------------------
       3. WHAT WE OFFER SECTION
    ---------------------------------------------------- */
    .offer-section {
        padding: 4.5rem 0;
        background: #ffffff;
        position: relative;
    }
    .offer-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8eee9;
        padding: 2.2rem 1.75rem;
        height: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }
    .offer-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(18, 53, 34, 0.08);
        border-color: #b7e4c7;
    }
    .offer-icon-circle {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin-bottom: 1.25rem;
    }
    .offer-icon-green { background: #d8f3dc; color: #1b4332; }
    .offer-icon-mint { background: #e8f5e9; color: #2d6a4f; }
    .offer-icon-coral { background: #ffebee; color: #e53935; }
    .offer-icon-teal { background: #e0f2f1; color: #00897b; }

    .offer-link {
        color: #1b4332;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: gap 0.2s ease;
    }
    .offer-link:hover {
        gap: 0.65rem;
        color: #2d6a4f;
    }

    /* ----------------------------------------------------
       4. WHY PLANTARIC SECTION
    ---------------------------------------------------- */
    .why-section {
        background: #f4f8f4;
        padding: 4.5rem 0;
        position: relative;
        overflow: hidden;
    }
    .why-feature-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #d8f3dc;
        color: #1b4332;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    /* ----------------------------------------------------
       5. OUR STORY SECTION
    ---------------------------------------------------- */
    .story-section {
        padding: 4.5rem 0;
    }
    .story-grid-images {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .story-img-tall {
        height: 240px;
        object-fit: cover;
        border-radius: 16px;
        width: 100%;
    }
    .story-dark-card {
        background: #0f3822;
        border-radius: 16px;
        padding: 1.75rem;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* ----------------------------------------------------
       6. BOTTOM CTA BANNER
    ---------------------------------------------------- */
    .cta-banner-card {
        background: linear-gradient(135deg, rgba(15, 56, 34, 0.92) 0%, rgba(27, 67, 50, 0.95) 100%),
                    url('{{ asset('images/about/cta_leaf_bg.jpg') }}') center/cover;
        border-radius: 24px;
        padding: 3.5rem 3rem;
        color: #ffffff;
        box-shadow: 0 20px 45px rgba(15, 56, 34, 0.25);
    }
</style>
@endpush

@section('content')

<!-- 1. HERO SECTION -->
<section class="hero-about-wrapper">
    <div class="hero-blob-bg"></div>
    <div class="container position-relative" style="z-index: 2;">

        <div class="row align-items-center g-4">
            <!-- Left Hero Text Content -->
            <div class="col-lg-6">
                <span class="section-eyebrow-pill">
                    <i class="fa-solid fa-seedling"></i> ABOUT PLANTARIC
                </span>

                <h1 class="main-heading-serif display-4 mb-3" style="font-size: clamp(2.4rem, 4.5vw, 3.6rem);">
                    Our Passion<br>Grows With You
                </h1>

                <p class="text-secondary fs-5 mb-4" style="line-height: 1.65; max-width: 520px;">
                    At Plantaric, we believe plants have the power to make life better. We're here to help everyone discover, learn, and grow with plants—whether at home, in the garden, or in the great outdoors.
                </p>

                <!-- 3 Mini Feature Indicators -->
                <div class="d-flex flex-wrap gap-4 pt-2">
                    <div class="hero-mini-feature">
                        <div class="hero-mini-icon">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark small">Learn</strong>
                            <span class="small text-muted">Reliable information</span>
                        </div>
                    </div>

                    <!-- <div class="hero-mini-feature">
                        <div class="hero-mini-icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark small">Shop</strong>
                            <span class="small text-muted">Quality plants & supplies</span>
                        </div>
                    </div> -->

                    <div class="hero-mini-feature">
                        <div class="hero-mini-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <strong class="d-block text-dark small">Grow Together</strong>
                            <span class="small text-muted">A thriving plant community</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Monstera Potted Plant Image & Handwritten Accent -->
            <div class="col-lg-6 text-center position-relative">
                <div class="position-relative d-inline-block">
                    <img src="{{ asset('images/about/hero_monstera.jpg') }}" alt="Monstera plant in ceramic pot" class="hero-monstera-img">

                    <!-- Handwritten Accent Overlay -->
                    <div class="position-absolute top-50 start-0 translate-middle-y ms-n4 d-none d-md-block text-start" style="z-index: 3;">
                        <span class="handwritten-text d-block">
                            Plants<br>
                            Make Life<br>
                            Brighter ⤵
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. OUR MISSION SECTION -->
<section class="mission-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Left Seedling Image with Badge -->
            <div class="col-lg-6">
                <div class="mission-img-card">
                    <img src="{{ asset('images/about/mission_seedling.jpg') }}" alt="Seedling in soil held by hands">
                    <div class="mission-overlay-badge">
                        <i class="fa-solid fa-leaf me-2" style="color: #6ee7b7;"></i>
                        "Healthier Plants.<br>Happier Lives."
                    </div>
                </div>
            </div>

            <!-- Right Mission Text & Stat Chips -->
            <div class="col-lg-6">
                <span class="section-eyebrow-pill">
                    <i class="fa-solid fa-bullseye"></i> OUR MISSION
                </span>

                <h2 class="main-heading-serif h1 mb-3">
                    Making Plant Knowledge<br>Accessible to Everyone
                </h2>

                <p class="text-secondary mb-4" style="line-height: 1.7; font-size: 1.05rem;">
                    Our mission is to provide accurate, practical, and easy-to-understand plant knowledge for everyone. From beginners to experienced plant lovers, we aim to be your trusted source for botanical information, gardening guidance, and quality plant products.
                </p>

                <!-- 3 Stat Chips Grid -->
                <div class="row g-3">
                    <div class="col-4">
                        <div class="stat-chip-card">
                            <div class="stat-chip-icon">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-5 mb-0">{{ number_format($stats['plants'] ?? 1) }}+</div>
                                <div class="small text-muted" style="font-size:0.75rem; line-height:1.2">Plant Species in Encyclopedia</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="stat-chip-card">
                            <div class="stat-chip-icon">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-5 mb-0">{{ number_format($stats['articles'] ?? 1) }}+</div>
                                <div class="small text-muted" style="font-size:0.75rem; line-height:1.2">Articles & Guides</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="stat-chip-card">
                            <div class="stat-chip-icon">
                                <i class="fa-solid fa-seedling"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-5 mb-0">Growing</div>
                                <div class="small text-muted" style="font-size:0.75rem; line-height:1.2">Community of Plant Lovers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. WHAT WE OFFER SECTION -->
<section class="offer-section">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-5">
            <span class="section-eyebrow-pill">
                <i class="fa-solid fa-leaf"></i> WHAT WE OFFER
            </span>
            <h2 class="main-heading-serif h1 mb-2">Everything You Need for a Greener Tomorrow</h2>
            <p class="text-muted">Plantaric brings together knowledge, products, and a community to make plant care simple and enjoyable.</p>
        </div>

        <!-- 4 Card Grid -->
        <div class="row g-4">
            <!-- Card 1: Plant Encyclopedia -->
            <div class="col-md-6 col-lg-3">
                <div class="offer-card">
                    <div class="offer-icon-circle offer-icon-green">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h3 class="h5 fw-bold text-dark mb-2" style="font-family:'Playfair Display',serif">Plant Encyclopedia</h3>
                    <p class="small text-muted mb-4" style="line-height:1.65;">
                        Explore detailed information about plant species, care requirements, and growing conditions.
                    </p>
                    <a href="{{ route('plants.index') }}" class="offer-link">
                        Explore Plants →
                    </a>
                </div>
            </div>

            <!-- Card 2: Gardening Articles -->
            <div class="col-md-6 col-lg-3">
                <div class="offer-card">
                    <div class="offer-icon-circle offer-icon-mint">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="h5 fw-bold text-dark mb-2" style="font-family:'Playfair Display',serif">Gardening Articles</h3>
                    <p class="small text-muted mb-4" style="line-height:1.65;">
                        Step-by-step guides, seasonal tips, plant care advice, and expert insights.
                    </p>
                    <a href="{{ route('articles.index') }}" class="offer-link">
                        Read Articles →
                    </a>
                </div>
            </div>

            <!-- Card 3: Plant Marketplace -->
            <div class="col-md-6 col-lg-3">
                <div class="offer-card">
                    <div class="offer-icon-circle offer-icon-coral">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <h3 class="h5 fw-bold text-dark mb-2" style="font-family:'Playfair Display',serif">Plant Marketplace</h3>
                    <p class="small text-muted mb-4" style="line-height:1.65;">
                        Find healthy plants, seeds, planters, and gardening supplies from trusted sources.
                    </p>
                    <a href="{{ route('shop.index') }}" class="offer-link">
                        Visit Shop →
                    </a>
                </div>
            </div>

            <!-- Card 4: Educational Resources -->
            <div class="col-md-6 col-lg-3">
                <div class="offer-card">
                    <div class="offer-icon-circle offer-icon-teal">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="h5 fw-bold text-dark mb-2" style="font-family:'Playfair Display',serif">Educational Resources</h3>
                    <p class="small text-muted mb-4" style="line-height:1.65;">
                        Helpful resources for home gardeners, students, and nature enthusiasts.
                    </p>
                    <a href="{{ route('guides.index') }}" class="offer-link">
                        Learn More →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. WHY PLANTARIC SECTION -->
<section class="why-section">
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <!-- Left 4 Feature Icons Column -->
            <div class="col-lg-8">
                <span class="section-eyebrow-pill">
                    <i class="fa-solid fa-leaf"></i> WHY PLANTARIC
                </span>

                <h2 class="main-heading-serif h1 mb-2">More Than Just a Website</h2>
                <p class="text-muted mb-5">We're building a platform where plant knowledge, care, and community come together.</p>

                <div class="row g-4">
                    <div class="col-sm-6 col-md-3">
                        <div class="why-feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <strong class="d-block text-dark mb-1">Reliable Information</strong>
                        <p class="small text-muted mb-0" style="line-height: 1.5;">Research-backed content you can trust.</p>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="why-feature-icon">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <strong class="d-block text-dark mb-1">Practical Guidance</strong>
                        <p class="small text-muted mb-0" style="line-height: 1.5;">Real-world tips for real plant lovers.</p>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="why-feature-icon">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <strong class="d-block text-dark mb-1">Community Focused</strong>
                        <p class="small text-muted mb-0" style="line-height: 1.5;">A space to share, learn, and grow together.</p>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <div class="why-feature-icon">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <strong class="d-block text-dark mb-1">Sustainable Living</strong>
                        <p class="small text-muted mb-0" style="line-height: 1.5;">Promoting greener and healthier spaces.</p>
                    </div>
                </div>
            </div>

            <!-- Right Snake Plant Image & Handwritten Text -->
            <div class="col-lg-4 text-center text-lg-end position-relative">
                <div class="position-relative d-inline-block">
                    <img src="{{ asset('images/about/why_plants.jpg') }}" alt="Indoor potted plants" class="rounded-4 shadow-sm" style="max-height: 340px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 translate-middle-x mt-3 d-none d-lg-block text-start">
                        <span class="handwritten-text text-dark d-block">
                            A Greener<br>Tomorrow 🌿
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. OUR STORY SECTION -->
<section class="story-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Left Collage of Images -->
            <div class="col-lg-6">
                <div class="story-grid-images">
                    <img src="{{ asset('images/about/story_greenhouse.jpg') }}" alt="Sunlit indoor garden hanging plants" class="story-img-tall">
                    <img src="{{ asset('images/about/story_repotting.jpg') }}" alt="Hands repotting green plant" class="story-img-tall">
                    <div class="story-dark-card col-span-2">
                        <span class="handwritten-text text-white d-block mb-1" style="font-size:1.6rem">
                            From a simple idea to a growing community.
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Story Text -->
            <div class="col-lg-6">
                <span class="section-eyebrow-pill">
                    <i class="fa-solid fa-book-open"></i> OUR STORY
                </span>

                <h2 class="main-heading-serif h1 mb-3">
                    Built by Plant Lovers,<br>for Plant Lovers
                </h2>

                <p class="text-secondary mb-3" style="line-height: 1.75; font-size: 1.05rem;">
                    Plantaric started with a simple idea — to make reliable plant knowledge accessible to everyone. What began as a personal passion for plants has grown into a comprehensive platform that helps thousands of plant enthusiasts around the world.
                </p>

                <p class="text-secondary mb-4" style="line-height: 1.75; font-size: 1.05rem;">
                    Today, we continue to expand our encyclopedia, publish helpful articles, and offer quality plants and supplies, all with the same goal: a greener, healthier, and happier tomorrow.
                </p>

                <a href="{{ route('plants.index') }}" class="btn btn-success fw-bold rounded-pill px-4 py-3 text-white shadow-sm" style="background: #0f3822; border-color: #0f3822;">
                    Join Our Journey →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 6. BOTTOM CTA BANNER -->
<div class="container mb-5">
    <div class="cta-banner-card">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="section-eyebrow-pill bg-white text-success border-0 mb-3">
                    <i class="fa-solid fa-leaf"></i> LET'S GROW TOGETHER
                </span>
                <h2 class="main-heading-serif display-5 text-white mb-2">Plants Inspire a Better Tomorrow</h2>
                <p class="text-white-50 fs-5 mb-0">Explore, learn, shop, and be part of a growing community.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg fw-bold rounded-pill px-4 py-3 text-dark shadow">
                    Explore Now →
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
