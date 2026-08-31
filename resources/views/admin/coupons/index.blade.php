@extends('layouts.admin')

@section('title', 'Coupons - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-ticket text-success me-2"></i>Coupons & Promotional Discounts</h1>
        <p class="text-muted small mb-0">Create and manage coupon codes for store discounts.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3">Create New Coupon</h5>
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Coupon Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control text-uppercase" placeholder="e.g. PLANTARIC10" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed (Rs.)</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Value <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="value" class="form-control" placeholder="10" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Min Order Subtotal (Rs.)</label>
                        <input type="number" step="0.01" name="minimum_order" class="form-control" placeholder="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-plus me-1"></i> Add Coupon</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Code</th>
                                <th>Discount</th>
                                <th>Min Order</th>
                                <th>Used</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="ps-4"><code class="fs-6 fw-bold text-success">{{ $coupon->code }}</code></td>
                                    <td>{{ $coupon->type->value === 'percentage' ? $coupon->value . '%' : 'Rs. ' . number_format($coupon->value, 0) }}</td>
                                    <td>{{ $coupon->minimum_order ? 'Rs. ' . number_format($coupon->minimum_order, 0) : 'None' }}</td>
                                    <td>{{ $coupon->usages_count }} times</td>
                                    <td><span class="badge {{ $coupon->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($coupon->status) }}</span></td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete coupon?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No coupons created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
