@extends('layouts.app')

@section('title', 'My Orders - Plantaric')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h1 class="h2 fw-bold text-dark mb-0">My Orders</h1>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="list-group border-0 shadow-sm rounded-3">
                <a href="{{ route('frontend.account.dashboard') }}" class="list-group-item list-group-item-action py-3">
                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                </a>
                <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action active fw-bold py-3">
                    <i class="fa-solid fa-box me-2"></i> My Orders
                </a>
                <a href="{{ route('frontend.account.addresses') }}" class="list-group-item list-group-item-action py-3">
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
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Order #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4 fw-bold text-success">{{ $order->order_number }}</td>
                                        <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td><span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td>
                                        <td class="fw-bold">Rs. {{ number_format($order->grand_total, 0) }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('frontend.account.orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-success">View Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
