@extends('layouts.admin')

@section('title', 'Shipping Methods - Plantora Admin')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-truck-fast text-success me-2"></i>Shipping Methods</h1>
    <p class="text-muted small mb-0">Configure flat rate shipping, free shipping thresholds, and local pickup.</p>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white font-weight-bold">Add Shipping Method</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.shipping-methods.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Method Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Standard Delivery" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code (Unique Identifier)</label>
                        <input type="text" name="code" class="form-control" placeholder="standard-delivery">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="flat_rate">Flat Rate</option>
                                <option value="free_shipping">Free Shipping</option>
                                <option value="pickup">Store Pickup</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Price (Rs.) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" value="250" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Free Shipping Threshold (Rs.)</label>
                        <input type="number" step="0.01" name="free_shipping_threshold" class="form-control" placeholder="3000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-plus me-1"></i> Save Method</button>
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
                                <th class="ps-4">Name</th>
                                <th>Code</th>
                                <th>Price</th>
                                <th>Free Threshold</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($methods as $m)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $m->name }}</td>
                                    <td><code>{{ $m->code }}</code></td>
                                    <td class="fw-bold">Rs. {{ number_format($m->price, 0) }}</td>
                                    <td>{{ $m->free_shipping_threshold ? 'Orders over Rs. ' . number_format($m->free_shipping_threshold, 0) : 'None' }}</td>
                                    <td><span class="badge {{ $m->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($m->status) }}</span></td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.shipping-methods.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete method?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No shipping methods configured yet.</td>
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
