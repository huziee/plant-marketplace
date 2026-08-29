@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - Plantora')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('frontend.account.orders') }}" class="text-decoration-none text-muted small"><i class="fa-solid fa-arrow-left me-1"></i> Back to Orders</a>
            <h1 class="h2 fw-bold text-dark mb-0 mt-1">Order #{{ $order->order_number }}</h1>
        </div>
        <span class="badge {{ $order->status->badgeClass() }} fs-6 px-3 py-2">{{ $order->status->label() }}</span>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-bold py-3">Order Items</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                            <small class="text-muted">SKU: {{ $item->sku }}</small>
                                        </td>
                                        <td>Rs. {{ number_format($item->unit_price, 0) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end pe-4 fw-bold text-success">Rs. {{ number_format($item->line_total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">Rs. {{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    @if($order->discount_total > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Discount</span>
                            <span>- Rs. {{ number_format($order->discount_total, 0) }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span>Rs. {{ number_format($order->shipping_total, 0) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between h5 fw-bold text-dark">
                        <span>Total</span>
                        <span class="text-success">Rs. {{ number_format($order->grand_total, 0) }}</span>
                    </div>
                </div>
            </div>

            @if($order->canBeCancelled())
                <form action="{{ route('frontend.account.orders.cancel', $order->order_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger"><i class="fa-solid fa-xmark me-1"></i> Cancel Order</button>
                </form>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white fw-bold py-3">Shipping Address</div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}</strong></p>
                    <p class="text-muted small mb-1">{{ $order->shipping_address['address_line_1'] ?? '' }}</p>
                    <p class="text-muted small mb-1">{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['country'] ?? '' }}</p>
                    <p class="text-muted small mb-0">Phone: {{ $order->customer_phone }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
