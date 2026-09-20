@extends('layouts.app')

@section('title', 'Your Shopping Cart - Plantaric')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h1 class="h2 fw-bold text-dark mb-0"><i class="fa-solid fa-cart-shopping text-success me-2"></i>Shopping Cart</h1>
    </div>
</div>

<div class="container py-4">
    @if($cart->items->isEmpty())
        <div class="text-center py-5">
            <i class="fa-solid fa-basket-shopping text-muted fa-4x mb-3"></i>
            <h3 class="fw-bold text-dark mb-2">Your cart is currently empty</h3>
            <p class="text-muted mb-4">Explore our plant marketplace and add healthy plants, seeds, or care supplies to your cart.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg px-4">Start Shopping &rarr;</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th class="text-end pe-4">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product->featuredImage)
                                                        <img src="{{ asset('storage/' . $item->product->featuredImage->file_path) }}" alt="{{ $item->product->name }}" class="rounded me-3" style="width: 55px; height: 55px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3 text-muted" style="width: 55px; height: 55px;">
                                                            <i class="fa-solid fa-leaf"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('frontend.shop.product', $item->product->slug) }}" class="fw-bold text-dark text-decoration-none">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        @if($item->variant)
                                                            <small class="text-muted d-block">{{ $item->variant->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-semibold">Rs. {{ number_format($item->unit_price, 0) }}</td>
                                            <td style="width: 130px;">
                                                <form action="{{ route('frontend.cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm text-center me-1" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="fw-bold text-success">Rs. {{ number_format($item->line_total, 0) }}</td>
                                            <td class="text-end pe-4">
                                                <form action="{{ route('frontend.cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 border-0"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Coupon Code</h5>
                        @if($appliedCoupon)
                            <div class="alert alert-success d-flex justify-content-between align-items-center mb-0">
                                <span>Code <strong>{{ $appliedCoupon->code }}</strong> applied</span>
                                <form action="{{ route('frontend.cart.coupon.remove') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-link text-danger p-0 text-decoration-none">Remove</button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('frontend.cart.coupon') }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="coupon_code" class="form-control" placeholder="Enter coupon code">
                                    <button class="btn btn-outline-success" type="submit">Apply</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold text-dark">Rs. {{ number_format($cart->subtotal, 0) }}</span>
                        </div>
                        @if($discountAmount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount</span>
                                <span>- Rs. {{ number_format($discountAmount, 0) }}</span>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between h5 fw-bold text-dark mb-4">
                            <span>Total</span>
                            <span class="text-success">Rs. {{ number_format(max(0, $cart->subtotal - $discountAmount), 0) }}</span>
                        </div>

                        <a href="{{ route('frontend.checkout.index') }}" class="btn btn-success btn-lg w-100 fw-bold">
                            Proceed to Checkout &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
