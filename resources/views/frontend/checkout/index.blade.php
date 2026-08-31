@extends('layouts.app')

@section('title', 'Checkout - Plantaric Store')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h1 class="h2 fw-bold text-dark mb-0"><i class="fa-solid fa-lock text-success me-2"></i>Checkout</h1>
    </div>
</div>

<div class="container py-4">
    <form action="{{ route('frontend.checkout.process') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white fw-bold py-3">1. Shipping Address</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address[first_name]" class="form-control" value="{{ old('shipping_address.first_name', $defaultAddress?->first_name ?: auth()->user()->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address[last_name]" class="form-control" value="{{ old('shipping_address.last_name', $defaultAddress?->last_name ?: '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="shipping_address[email]" class="form-control" value="{{ old('shipping_address.email', auth()->user()->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address[phone]" class="form-control" value="{{ old('shipping_address.phone', $defaultAddress?->phone ?: '') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address[address_line_1]" class="form-control" value="{{ old('shipping_address.address_line_1', $defaultAddress?->address_line_1 ?: '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address[city]" class="form-control" value="{{ old('shipping_address.city', $defaultAddress?->city ?: 'Lahore') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address[country]" class="form-control" value="{{ old('shipping_address.country', 'Pakistan') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white fw-bold py-3">2. Shipping Method</div>
                    <div class="card-body">
                        @foreach($shippingMethods as $method)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="shipping_method_id" value="{{ $method['id'] }}" id="ship_{{ $method['id'] }}" {{ $loop->first ? 'checked' : '' }}>
                                <label class="form-check-label d-flex justify-content-between w-100 pe-3" for="ship_{{ $method['id'] }}">
                                    <span><strong>{{ $method['name'] }}</strong></span>
                                    <span class="fw-bold text-success">{{ $method['cost'] == 0 ? 'FREE' : 'Rs. ' . number_format($method['cost'], 0) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white fw-bold py-3">3. Payment Method</div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="cash_on_delivery" id="cod" checked>
                            <label class="form-check-label fw-bold" for="cod">
                                Cash on Delivery (COD)
                            </label>
                            <p class="text-muted small mb-0 mt-1">Pay with cash upon receiving your plants at your doorstep.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white fw-bold py-3">Order Summary</div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($cart->items as $item)
                                <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->product->name }}</div>
                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                    </div>
                                    <span class="fw-bold text-dark">Rs. {{ number_format($item->line_total, 0) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer bg-light border-0 p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-semibold">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                        </div>
                        @if($discountAmount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount</span>
                                <span>- Rs. {{ number_format($discountAmount, 0) }}</span>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between h4 fw-bold text-dark mb-4">
                            <span>Total</span>
                            <span class="text-success">Rs. {{ number_format(max(0, $cart->subtotal - $discountAmount), 0) }}</span>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100 fw-bold py-3">
                            Place Order (COD) &rarr;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
