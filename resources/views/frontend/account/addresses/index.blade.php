@extends('layouts.app')

@section('title', 'My Addresses - Plantaric')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h1 class="h2 fw-bold text-dark mb-0">My Shipping Addresses</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="list-group border-0 shadow-sm rounded-3">
                <a href="{{ route('frontend.account.dashboard') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>
                <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-box me-2"></i> My Orders
                </a>
                <a href="{{ route('frontend.account.addresses') }}" class="list-group-item list-group-item-action active fw-bold py-3">
                    <i class="fa-solid fa-location-dot me-2"></i> Addresses
                </a>
                <a href="{{ route('frontend.account.password') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-key me-2"></i> Security & Password
                </a>
                <a href="{{ route('frontend.account.wishlist') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-heart me-2"></i> Wishlist
                </a>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4 mb-4">
                @forelse($addresses as $addr)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="fw-bold text-dark mb-0">{{ $addr->full_name }}</h6>
                                    @if($addr->is_default_shipping)
                                        <span class="badge bg-success-subtle text-success border border-success">Default</span>
                                    @endif
                                </div>
                                <p class="small text-muted mb-2">{{ $addr->formatted_address }}</p>
                                <p class="small text-muted mb-3">Phone: {{ $addr->phone }}</p>

                                <form action="{{ route('frontend.account.addresses.delete', $addr) }}" method="POST" onsubmit="return confirm('Delete address?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash me-1"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No addresses saved yet. Fill in the form below to add your first address.</p>
                    </div>
                @endforelse
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white fw-bold py-3">Add New Address</div>
                <div class="card-body">
                    <form action="{{ route('frontend.account.addresses.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" name="address_line_1" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="country" class="form-control" value="Pakistan" required>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default_shipping" value="1" id="is_def" checked>
                                    <label class="form-check-label" for="is_def">Set as default shipping address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus me-1"></i> Save Address</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
