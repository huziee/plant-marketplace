@extends('layouts.app')

@section('title', 'Editorial Policy | Plantaric')
@section('meta_description', 'Learn how Plantaric researches, creates, reviews, and maintains botanical articles, plant care information, and gardening news.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'Editorial Policy',
        'subtitle' => 'How Plantaric creates, researches, verifies, and maintains botanical and gardening content.',
        'icon' => 'fa-solid fa-feather-pointed'
    ])

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill" style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            <i class="fa-solid fa-shield-check me-1"></i> Editorial Policy
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> Last Updated: September 2026
                        </span>
                    </div>

                    <h2 class="h3 font-weight-bold text-dark mb-3" style="font-family:'Playfair Display',serif">
                        Our Commitment to Quality & Reliable Plant Knowledge
                    </h2>

                    <p class="lead text-secondary mb-3" style="font-size: 1.05rem; line-height: 1.75;">
                        At Plantaric, we are committed to providing informative, accurate, and practical content that helps readers better understand plants, gardening, and sustainable growing practices.
                    </p>
                    <p class="text-secondary mb-4" style="line-height: 1.75;">
                        Our editorial policy explains how we create, review, and maintain the information published on <strong>plantaric.com</strong>.
                    </p>

                    <div class="border-top pt-3">
                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-circle-check text-success me-2"></i> 1. Content Quality & Accuracy
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We aim to publish original, well-researched, and easy-to-understand articles about plant care, gardening, agriculture, and botanical knowledge. Our content is developed using relevant educational resources and reliable information wherever possible.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-robot text-success me-2"></i> 2. AI-Assisted Content
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Plantaric may use artificial intelligence to assist with content research, drafting, editing, and visual creation. We aim to review AI-assisted material for accuracy, clarity, and usefulness before publication.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-scale-balanced text-success me-2"></i> 3. Editorial Independence
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Our educational content is intended to provide value to readers. Advertising, sponsored content, and commercial partnerships do not automatically determine our editorial recommendations. Paid promotions and affiliate relationships are disclosed where applicable.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-arrows-rotate text-success me-2"></i> 4. Content Updates & Corrections
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We aim to keep our information relevant and accurate. Articles may be updated to correct errors, improve explanations, or reflect new botanical research and gardening practices.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-triangle-exclamation text-success me-2"></i> 5. Plant Care Disclaimer
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Plant growth depends on environmental conditions, plant species, soil, climate, and individual care practices. Our content is provided for general educational purposes, and specific growing results cannot be guaranteed.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-comments text-success me-2"></i> 6. Reader Feedback
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We welcome feedback, corrections, and suggestions from our readers. If you notice inaccurate or outdated information, please contact us through our <a href="{{ route('frontend.contact') }}" class="text-success fw-bold text-decoration-underline">Contact Us page</a>.
                        </p>
                    </div>

                    <div class="alert alert-success border-0 rounded-4 p-4 mt-5 text-center" style="background:#ecfdf5;color:#065f46;">
                        <i class="fa-solid fa-leaf fa-2x mb-2 text-success"></i>
                        <div class="fw-bold fs-5 text-dark" style="font-family:'Playfair Display',serif">
                            Plantaric — Discover Plants. Grow Knowledge. Embrace Nature.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Sidebar Navigation -->
            <div class="col-lg-4">
                @include('layouts.partials.policy-sidebar')
            </div>
        </div>
    </div>
@endsection
