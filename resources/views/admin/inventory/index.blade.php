@extends('layouts.admin')

@section('title', 'Inventory Audit Log - Plantaric Admin')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-boxes-packing text-success me-2"></i>Inventory Movements & Audit Trail</h1>
    <p class="text-muted small mb-0">Track initial stock, customer sales, restocks, returns, and manual adjustments.</p>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.inventory.index') }}" class="row g-3">
            <div class="col-md-6">
                <select name="product_id" class="form-select">
                    <option value="">All Products</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}" {{ request('product_id') == $prod->id ? 'selected' : '' }}>{{ $prod->name }} (SKU: {{ $prod->sku }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="type" class="form-select">
                    <option value="">All Movement Types</option>
                    <option value="initial" {{ request('type') === 'initial' ? 'selected' : '' }}>Initial Stock</option>
                    <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>Customer Sale</option>
                    <option value="restock" {{ request('type') === 'restock' ? 'selected' : '' }}>Restock</option>
                    <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                    <option value="cancelled_order_restore" {{ request('type') === 'cancelled_order_restore' ? 'selected' : '' }}>Cancelled Order Restore</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Product</th>
                        <th>Movement Type</th>
                        <th>Change</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>Notes / Reference</th>
                        <th>By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $m)
                        <tr>
                            <td class="ps-4 small text-muted">{{ $m->created_at->format('M d, Y H:i') }}</td>
                            <td class="fw-bold text-dark">{{ $m->product ? $m->product->name : 'Deleted Product' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $m->type->label() }}</span></td>
                            <td class="fw-bold {{ $m->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $m->quantity > 0 ? '+' : '' }}{{ $m->quantity }}
                            </td>
                            <td>{{ $m->quantity_before }}</td>
                            <td class="fw-bold">{{ $m->quantity_after }}</td>
                            <td class="small">{{ $m->notes }}</td>
                            <td class="small text-muted">{{ $m->creator ? $m->creator->name : 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No inventory movements recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($movements->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $movements->links() }}
        </div>
    @endif
</div>
@endsection
