@extends('layouts.app')

@section('title', 'Order Placed - Plantora')

@section('content')
<div class="container py-5 text-center">
    <div class="card border-0 shadow-sm rounded-3 p-5 mx-auto" style="max-width: 650px;">
        <div class="text-success mb-3">
            <i class="fa-solid fa-circle-check fa-4x"></i>
        </div>
        <h1 class="fw-bold text-dark mb-2">Thank You for Your Order!</h1>
        <p class="text-muted fs-5 mb-4">Your order <strong>#{{ $order->order_number }}</strong> has been successfully placed.</p>

        <div class="bg-light p-3 rounded-3 text-start mb-4">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Order Date:</span>
                <span class="fw-bold text-dark">{{ $order->created_at->format('M d, Y h:i A') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Payment Method:</span>
                <span class="fw-bold text-dark">Cash on Delivery (COD)</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Total Amount:</span>
                <span class="fw-bold text-success">Rs. {{ number_format($order->grand_total, 0) }}</span>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('frontend.account.orders.show', $order->order_number) }}" class="btn btn-outline-success">View Order Details</a>
            <a href="{{ route('shop.index') }}" class="btn btn-success">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection
