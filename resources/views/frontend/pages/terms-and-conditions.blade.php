@extends('layouts.app')

@section('title', 'Terms & Conditions | Plantaric')
@section('meta_description', 'Read Plantaric\'s terms and conditions covering website use, botanical content, customer accounts, product purchases, and online shopping.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'Terms & Conditions',
        'subtitle' => 'Official terms governing website access, marketplace orders, and botanical resources on Plantaric.',
        'icon' => 'fa-solid fa-file-contract'
    ])

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap gap-2">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill" style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            <i class="fa-solid fa-file-contract me-1"></i> Terms & Conditions
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> Last Updated: September 21, 2026
                        </span>
                    </div>

                    <p class="lead text-secondary mb-4" style="font-size: 1.05rem; line-height: 1.75;">
                        Welcome to Plantaric (<strong>plantaric.com</strong>). By accessing or using our website, you agree to the following Terms & Conditions. Please read them carefully before using our services.
                    </p>

                    <div class="border-top pt-3">
                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-desktop text-success me-2"></i> 1. Use of Our Website
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Plantaric provides plant care information, gardening articles, botanical resources, and marketplace services. Users agree to use our platform responsibly and for lawful purposes.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-user-lock text-success me-2"></i> 2. User Accounts
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Users are responsible for maintaining the confidentiality of their account information and ensuring that the details they provide are accurate.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-store text-success me-2"></i> 3. Marketplace Activities
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Plantaric may allow users to buy, sell, or explore plants and gardening-related products. Sellers are responsible for providing accurate product descriptions, pricing, and relevant product information.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-copyright text-success me-2"></i> 4. Content & Intellectual Property
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Articles, images, guides, and other original content published by Plantaric are protected by applicable intellectual property laws. Unauthorized copying, reproduction, or commercial use is prohibited without appropriate permission.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-circle-info text-success me-2"></i> 5. Information Disclaimer
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Our gardening articles and plant care guides are provided for general educational purposes. Plant growth and care results may vary depending on environmental conditions and individual practices.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-link text-success me-2"></i> 6. Third-Party Links & Advertising
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            Our website may contain advertisements and links to external websites. Plantaric is not responsible for the content, products, or practices of third-party platforms.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-pen-to-square text-success me-2"></i> 7. Changes to Our Terms
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            We may update these Terms & Conditions when necessary. Continued use of Plantaric after changes become effective constitutes acceptance of the updated terms, where permitted by applicable law.
                        </p>

                        <h3 class="h5 font-weight-bold text-dark mt-4 mb-3" style="font-family:'Playfair Display',serif">
                            <i class="fa-solid fa-envelope text-success me-2"></i> 8. Contact Us
                        </h3>
                        <p class="text-secondary" style="line-height:1.75;">
                            For questions regarding these Terms & Conditions, please contact us through our <a href="{{ route('frontend.contact') }}" class="text-success fw-bold text-decoration-underline">Contact Us page</a>.
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
