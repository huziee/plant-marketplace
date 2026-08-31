@extends('layouts.app')

@section('title', $page->meta_title ?: 'About Us — Plantaric')
@section('meta_description', $page->meta_description ?: 'Learn about Plantaric, an all-in-one platform combining a plant marketplace, botanical encyclopedia, diagnostic plant doctor, and growing guides.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'About Us',
        'subtitle' => 'Combining plant knowledge, diagnostics, and shopping into one accessible botanical platform.',
        'icon' => 'fa-solid fa-leaf'
    ])

    <div class="container mb-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    {!! $page->content !!}
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 bg-white border rounded-4 shadow-sm sticky-top" style="top:100px">
                    <h4 class="h5 font-weight-bold mb-3" style="font-family:'Playfair Display',serif">Quick Nav</h4>
                    <div class="list-group list-group-flush mb-4">
                        <a href="{{ route('shop.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center fw-bold py-3">
                            <span><i class="fa-solid fa-shop text-success me-2"></i> Plant Marketplace</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('plants.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center fw-bold py-3">
                            <span><i class="fa-solid fa-book text-success me-2"></i> Botanical Encyclopedia</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('problems.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center fw-bold py-3">
                            <span><i class="fa-solid fa-stethoscope text-warning me-2"></i> Plant Doctor</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('guides.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center fw-bold py-3">
                            <span><i class="fa-solid fa-graduation-cap text-primary me-2"></i> Growing Guides</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                    </div>

                    <div class="p-3 bg-light rounded-3 text-center">
                        <i class="fa-solid fa-envelope text-success fa-2x mb-2"></i>
                        <h5 class="h6 font-weight-bold mb-1">Have Questions?</h5>
                        <p class="small text-muted mb-3">Our botanical support team is here to assist with plant advice and order inquiries.</p>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-sm btn-success w-100 fw-bold" style="border-radius:10px">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
