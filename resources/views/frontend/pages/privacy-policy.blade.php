@extends('layouts.app')

@section('title', 'Privacy Policy | Plantaric')
@section('meta_description', 'Learn how Plantaric collects, uses, and protects your personal information when shopping for plants, exploring botanical resources, and using our website.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'Privacy Policy',
        'subtitle' => 'How Plantaric collects, uses, protects, and handles your personal information.',
        'icon' => 'fa-solid fa-user-shield'
    ])

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill" style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            <i class="fa-solid fa-user-shield me-1"></i> Privacy Policy
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> Last Updated: September 21, 2026
                        </span>
                    </div>

                    <p class="lead text-secondary mb-4" style="font-size: 1.05rem; line-height: 1.75;">
                        At Plantaric (<strong>plantaric.com</strong>), we value your privacy and are committed to protecting your personal information. This policy explains how we collect, use, and safeguard your data.
                    </p>

                    <div class="border-top pt-3">
                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-database text-success me-2"></i> 1. Information We Collect
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We may collect your name, email address, account details, and information submitted through forms or marketplace activities. We may also collect technical data, including IP addresses, browser information, and website usage.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-gears text-success me-2"></i> 2. How We Use Information
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We use collected information to improve our services, manage accounts, support marketplace activities, respond to inquiries, and maintain website security.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-cookie-bite text-success me-2"></i> 3. Cookies & Advertising
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Plantaric uses cookies to improve website functionality and understand visitor activity. We may display advertisements through Google AdSense and other advertising partners. Google and third-party vendors may use cookies to serve ads based on your visits to this and other websites.
                        </p>
                        <p class="text-secondary" style="line-height:1.75;">
                            You can manage personalized advertising through <a href="https://adssettings.google.com/" target="_blank" rel="noopener" class="text-success fw-bold text-decoration-underline">Google Ads Settings</a>.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-handshake text-success me-2"></i> 4. Third-Party Services
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We may use third-party services for analytics, advertising, payment processing, and website operations. These providers may process information according to their respective privacy policies.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-shield-halved text-success me-2"></i> 5. Data Security
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We take reasonable measures to protect your information. However, no online platform can guarantee absolute security.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-user-check text-success me-2"></i> 6. Your Privacy Rights
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            You may request access to, correction of, or deletion of your personal information, subject to applicable laws.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-arrows-rotate text-success me-2"></i> 7. Policy Updates
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We may update this Privacy Policy when necessary. Changes will be published on this page.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-envelope text-success me-2"></i> 8. Contact Us
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            For privacy-related questions or requests, please contact us through our <a href="{{ route('frontend.contact') }}" class="text-success fw-bold text-decoration-underline">Contact Us page</a>.
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
