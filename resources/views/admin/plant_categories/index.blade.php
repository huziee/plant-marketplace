@extends('layouts.admin')

@section('title', 'Plant Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Plant Categories</h2>
        <p class="text-muted small mb-0">Organize botanical plants by family, indoor/outdoor habitats, and care levels.</p>
    </div>
    <a href="{{ route('admin.plant-categories.create') }}" class="btn btn-success fw-bold" style="border-radius:12px;background:var(--green-900)">
        <i class="fa-solid fa-plus me-1"></i> Add Category
    </a>
</div>

<div class="card card-custom">
    <!-- Filter bar -->
    <form method="GET" action="{{ route('admin.plant-categories.index') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search categories..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.plant-categories.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:60px">Image</th>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Sort Order</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image->file_path) }}" class="rounded" style="width:40px;height:40px;object-fit:cover">
                            @else
                                <div class="bg-light rounded d-grid place-items-center text-muted" style="width:40px;height:40px;font-size:12px;text-align:center;line-height:40px">
                                    <i class="fa-solid fa-leaf"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="d-block">{{ $category->name }}</strong>
                            <small class="text-muted">/{{ $category->slug }}</small>
                        </td>
                        <td>
                            @if($category->parent)
                                <span class="badge bg-light text-dark"><i class="fa-solid fa-turn-up me-1"></i> {{ $category->parent->name }}</span>
                            @else
                                <span class="text-muted small">Top Level</span>
                            @endif
                        </td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            @if($category->is_featured)
                                <span class="badge bg-success-subtle text-success">Featured</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>
                            @if($category->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.plant-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.plant-categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No plant categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
</div>
@endsection
