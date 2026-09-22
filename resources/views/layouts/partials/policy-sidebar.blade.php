@php
    $currentRoute = Route::currentRouteName();
@endphp

<div class="p-4 bg-white border rounded-4 shadow-sm sticky-top" style="top: 100px;">
    <h4 class="h6 text-uppercase fw-bold text-muted mb-3" style="letter-spacing: 0.5px;">Company & Policies</h4>
    <div class="list-group list-group-flush mb-4">
        <a href="{{ route('frontend.about') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.about' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-leaf me-2 {{ $currentRoute == 'frontend.about' ? 'text-white' : 'text-success' }}"></i> About Us</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
        <a href="{{ route('frontend.contact') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.contact' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-headset me-2 {{ $currentRoute == 'frontend.contact' ? 'text-white' : 'text-success' }}"></i> Contact Us</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
        <a href="{{ route('frontend.editorial-policy') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.editorial-policy' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-feather-pointed me-2 {{ $currentRoute == 'frontend.editorial-policy' ? 'text-white' : 'text-success' }}"></i> Editorial Policy</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
        <a href="{{ route('frontend.privacy') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.privacy' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-user-shield me-2 {{ $currentRoute == 'frontend.privacy' ? 'text-white' : 'text-success' }}"></i> Privacy Policy</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
        <a href="{{ route('frontend.terms') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.terms' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-file-contract me-2 {{ $currentRoute == 'frontend.terms' ? 'text-white' : 'text-success' }}"></i> Terms & Conditions</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
        <a href="{{ route('frontend.shipping-policy') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.shipping-policy' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-truck-fast me-2 {{ $currentRoute == 'frontend.shipping-policy' ? 'text-white' : 'text-success' }}"></i> Shipping Policy</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
        <a href="{{ route('frontend.return-refund-policy') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2.5 px-3 rounded-3 mb-1 {{ $currentRoute == 'frontend.return-refund-policy' ? 'bg-success text-white fw-bold' : 'fw-semibold text-dark' }}">
            <span><i class="fa-solid fa-rotate-left me-2 {{ $currentRoute == 'frontend.return-refund-policy' ? 'text-white' : 'text-success' }}"></i> Return & Refund</span>
            <i class="fa-solid fa-chevron-right small opacity-50"></i>
        </a>
    </div>

    <div class="p-3.5 bg-light rounded-3 text-center border">
        <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-2" style="width:42px;height:42px;">
            <i class="fa-solid fa-circle-question fa-lg"></i>
        </div>
        <h5 class="h6 font-weight-bold mb-1" style="font-family:'Playfair Display',serif">Need Clarification?</h5>
        <p class="small text-muted mb-3" style="font-size: 0.825rem; line-height: 1.5;">Our support team is available to help answer questions about our policies or your order.</p>
        <a href="{{ route('frontend.contact') }}" class="btn btn-sm btn-success w-100 fw-bold" style="border-radius:10px">Contact Support</a>
    </div>
</div>
