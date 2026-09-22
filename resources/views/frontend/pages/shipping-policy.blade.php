@extends('layouts.app')

@section('title', 'Shipping & Delivery Policy | Plantaric')
@section('meta_description', 'Learn about Plantaric\'s shipping methods, delivery charges, order processing, live plant packaging, and delivery procedures.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'Shipping & Delivery Policy',
        'subtitle' => 'How Plantaric safely packages, dispatches, and delivers live plants and botanical products.',
        'icon' => 'fa-solid fa-truck-fast'
    ])

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill" style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            <i class="fa-solid fa-truck-fast me-1"></i> Shipping Policy
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> Last Updated: September 21, 2026
                        </span>
                    </div>

                    <p class="lead text-secondary mb-4" style="font-size: 1.05rem; line-height: 1.75;">
                        At Plantaric (<strong>plantaric.com</strong>), we aim to provide a transparent and reliable marketplace experience for buyers and sellers. This Shipping Policy explains how shipping and delivery are handled for products purchased through our platform.
                    </p>

                    <div class="border-top pt-3">
                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-truck-ramp-box text-success me-2"></i> 1. Shipping & Delivery
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Shipping arrangements may vary depending on the seller, product type, and delivery location. Sellers are responsible for providing accurate shipping information and fulfilling orders according to their stated terms.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-tags text-success me-2"></i> 2. Shipping Charges
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Shipping costs, where applicable, may vary based on product size, weight, delivery destination, and the seller's selected shipping method. Available charges should be communicated before order confirmation.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-regular fa-clock text-success me-2"></i> 3. Delivery Time
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Estimated delivery times depend on the seller's processing schedule, product availability, shipping provider, and destination. Delivery estimates are not guaranteed.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-seedling text-success me-2"></i> 4. Live Plants & Special Handling
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Live plants may require special packaging and handling to maintain their condition during transportation. Sellers are responsible for selecting appropriate packaging and shipping methods for their products.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-triangle-exclamation text-success me-2"></i> 5. Delays & Delivery Issues
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Delivery delays may occur due to weather conditions, courier operations, incorrect addresses, or circumstances beyond the seller's control. Buyers should contact the seller regarding delayed, missing, or damaged orders.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-ban text-success me-2"></i> 6. Shipping Restrictions
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Certain plants and gardening products may be subject to local shipping restrictions or agricultural regulations. Sellers and buyers are responsible for complying with applicable requirements.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-envelope text-success me-2"></i> 7. Contact Us
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            For questions about our Shipping Policy or marketplace-related concerns, please contact us through our <a href="{{ route('frontend.contact') }}" class="text-success fw-bold text-decoration-underline">Contact Us page</a>.
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
