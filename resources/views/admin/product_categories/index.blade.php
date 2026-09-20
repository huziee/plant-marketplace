@extends('layouts.admin')

@section('title', 'Product Categories - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-folder-tree text-success me-2"></i>Product Categories</h1>
        <p class="text-muted small mb-0">Organize ecommerce products by hierarchy and category taxonomy.</p>
    </div>
    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-success">
        <i class="fa-solid fa-plus me-1"></i> Add Category
    </a>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.product-categories.index') }}" class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search categories..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <th class="ps-4" style="width:60px">Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-4">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image->file_path) }}" class="rounded" style="width:40px;height:40px;object-fit:cover">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width:40px;height:40px;font-size:12px">
                                        <i class="fa-solid fa-folder"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold text-dark">{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ $category->parent ? $category->parent->name : '—' }}</td>
                            <td>
                                <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($category->status) }}
                                </span>
                            </td>
                            <td>
                                @if($category->is_featured)
                                    <span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i> Featured</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.product-categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No product categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($categories->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
