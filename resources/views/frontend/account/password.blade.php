@extends('layouts.app')

@section('title', 'Change Password - Plantaric')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h1 class="h2 fw-bold text-dark mb-0">My Account</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="list-group border-0 shadow-sm rounded-3">
                <a href="{{ route('frontend.account.dashboard') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>
                <a href="{{ route('frontend.account.profile') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-regular fa-id-card me-2"></i> My Profile
                </a>
                <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-box me-2"></i> My Orders
                </a>
                <a href="{{ route('frontend.account.addresses') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-location-dot me-2"></i> Addresses
                </a>
                <a href="{{ route('frontend.account.password') }}" class="list-group-item list-group-item-action active fw-bold py-3">
                    <i class="fa-solid fa-key me-2"></i> Security & Password
                </a>
                <a href="{{ route('frontend.account.wishlist') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-heart me-2"></i> Wishlist
                </a>
            </div>
        </div>

        <div class="col-lg-9">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-3" style="max-width: 600px;">
                <div class="card-header bg-white fw-bold py-3 border-bottom">
                    <i class="fa-solid fa-lock text-success me-2"></i> Change Password
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('frontend.account.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold small">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold small">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
                            <small class="text-muted">Password must be at least 8 characters long.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold small">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
                        </div>

                        <button type="submit" class="btn btn-success fw-bold px-4 py-2">
                            <i class="fa-solid fa-key me-1"></i> Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
