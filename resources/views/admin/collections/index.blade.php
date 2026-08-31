@extends('layouts.admin')

@section('title', 'Product Collections - Plantaric Admin')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-layer-group text-success me-2"></i>Product Collections ("Shop by Need")</h1>
    <p class="text-muted small mb-0">Group products into custom curated collections like Low Light Plants, Air Purifiers, or Pet-Friendly.</p>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white font-weight-bold">Create Collection</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.product-collections.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Collection Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Low Light Living Room Plants" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" name="slug" class="form-control" placeholder="low-light-plants">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                        <label class="form-check-label" for="is_featured">Feature on Shop Homepage</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-plus me-1"></i> Save Collection</button>
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
                                <th class="ps-4">Collection</th>
                                <th>Slug</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collections as $col)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $col->name }}</td>
                                    <td><code>{{ $col->slug }}</code></td>
                                    <td>{{ $col->products_count }} products</td>
                                    <td><span class="badge {{ $col->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($col->status) }}</span></td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.product-collections.destroy', $col) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete collection?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No custom product collections created yet.</td>
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
