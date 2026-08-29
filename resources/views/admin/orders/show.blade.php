@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
        </a>
        <h1 class="h3 mb-0 text-gray-800 mt-2">Order #{{ $order->order_number }}</h1>
        <small class="text-muted">Placed on {{ $order->placed_at ? $order->placed_at->format('F d, Y \a\t h:i A') : $order->created_at->format('F d, Y') }}</small>
    </div>
    <div>
        <span class="badge {{ $order->status->badgeClass() }} fs-6 px-3 py-2">
            {{ $order->status->label() }}
        </span>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white font-weight-bold">Ordered Items</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Item</th>
                                <th>SKU</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $item->product_name }}</td>
                                    <td><code>{{ $item->sku }}</code></td>
                                    <td>Rs. {{ number_format($item->unit_price, 0) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end pe-4 fw-bold">Rs. {{ number_format($item->line_total, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-3">
                <div class="row text-end">
                    <div class="col-md-6 offset-md-6">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-semibold">Rs. {{ number_format($order->subtotal, 0) }}</span>
                        </div>
                        @if($order->discount_total > 0)
                            <div class="d-flex justify-content-between mb-1 text-success">
                                <span>Discount ({{ $order->coupon ? $order->coupon->code : 'Coupon' }}):</span>
                                <span>- Rs. {{ number_format($order->discount_total, 0) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Shipping:</span>
                            <span>Rs. {{ number_format($order->shipping_total, 0) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between h5 text-dark font-weight-bold">
                            <span>Grand Total:</span>
                            <span>Rs. {{ number_format($order->grand_total, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white font-weight-bold">Status History & Notes</div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-3">
                    @foreach($order->statusHistories as $history)
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ ucfirst($history->from_status) ?: 'Initiated' }} &rarr; {{ ucfirst($history->to_status) }}</span>
                                <small class="text-muted">{{ $history->created_at->format('M d, Y H:i') }}</small>
                            </div>
                            @if($history->notes)<small class="text-muted d-block">{{ $history->notes }}</small>@endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white font-weight-bold">Update Status</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            @foreach($statuses as $st)
                                <option value="{{ $st->value }}" {{ $order->status->value === $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Notes</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Optional internal or customer note"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-save me-1"></i> Update Status</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white font-weight-bold">Customer & Shipping Info</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> {{ $order->user ? $order->user->name : 'Guest' }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p class="mb-3"><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <hr>
                <h6 class="font-weight-bold mb-2">Shipping Address</h6>
                <p class="small text-muted mb-0">
                    {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
                    {{ $order->shipping_address['address_line_1'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['country'] ?? '' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
