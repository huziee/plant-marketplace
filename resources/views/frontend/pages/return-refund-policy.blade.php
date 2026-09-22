@extends('layouts.app')

@section('title', 'Return & Refund Policy | Plantaric')
@section('meta_description', 'Understand Plantaric\'s return and refund procedures for plants, gardening products, damaged deliveries, and order cancellations.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'Return & Refund Policy',
        'subtitle' => 'Our 30-Day Healthy Plant Guarantee, return guidelines, and refund procedures.',
        'icon' => 'fa-solid fa-rotate-left'
    ])

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill" style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            <i class="fa-solid fa-rotate-left me-1"></i> Return & Refund Policy
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> Last Updated: September 21, 2026
                        </span>
                    </div>

                    <p class="lead text-secondary mb-4" style="font-size: 1.05rem; line-height: 1.75;">
                        At Plantaric (<strong>plantaric.com</strong>), we aim to provide a transparent and trustworthy marketplace experience. This Return & Refund Policy explains how returns, refunds, and order-related concerns are handled.
                    </p>

                    <div class="border-top pt-3">
                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-clipboard-check text-success me-2"></i> 1. Return Eligibility
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Return eligibility may vary depending on the product type, condition, and seller's return terms. Buyers should review the applicable product and seller information before completing a purchase.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-seedling text-success me-2"></i> 2. Live Plants & Perishable Products
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Live plants are sensitive to transportation and environmental conditions. Returns involving live plants may be subject to special conditions due to their perishable nature, without affecting applicable consumer rights.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-box-tissue text-success me-2"></i> 3. Damaged or Incorrect Products
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            If you receive a damaged, defective, or incorrect product, please contact the seller promptly and provide relevant order details and photographs where possible.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-credit-card text-success me-2"></i> 4. Refund Processing
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Approved refunds are processed according to the applicable seller's terms, payment method, and marketplace arrangements. Processing times may vary depending on the payment provider.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-ban text-success me-2"></i> 5. Order Cancellations
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Cancellation requests are subject to the seller's order processing status and applicable cancellation terms. Orders that have already been shipped may be subject to additional conditions.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-user-shield text-success me-2"></i> 6. Seller Responsibilities
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Sellers are responsible for providing accurate product information, communicating return conditions, and addressing eligible refund requests in accordance with applicable consumer protection laws.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-envelope text-success me-2"></i> 7. Contact Us
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            For questions about returns, refunds, or marketplace-related concerns, please contact us through our <a href="{{ route('frontend.contact') }}" class="text-success fw-bold text-decoration-underline">Contact Us page</a>.
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
