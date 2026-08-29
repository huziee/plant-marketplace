@extends('layouts.admin')

@section('title', 'Plant Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Plant Encyclopedia</h2>
        <p class="text-muted small mb-0">Manage botanical profiles, scientific classifications, care guides, and problem associations.</p>
    </div>
    <a href="{{ route('admin.plants.create') }}" class="btn btn-success fw-bold" style="border-radius:12px;background:var(--green-900)">
        <i class="fa-solid fa-plus me-1"></i> Add Plant Profile
    </a>
</div>

<div class="card card-custom">
    <!-- Filters -->
    <form method="GET" action="{{ route('admin.plants.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, scientific name..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach(\App\Models\PlantCategory::active()->orderBy('name')->get() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.plants.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:60px">Image</th>
                    <th>Plant Name & Taxonomy</th>
                    <th>Category</th>
                    <th>Difficulty</th>
                    <th>Habitat</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plants as $plant)
                    <tr>
                        <td>
                            @if($plant->featuredImage)
                                <img src="{{ asset('storage/' . $plant->featuredImage->file_path) }}" class="rounded" style="width:44px;height:44px;object-fit:cover">
                            @else
                                <div class="bg-light rounded d-grid place-items-center text-muted" style="width:44px;height:44px;line-height:44px;text-align:center">
                                    <i class="fa-solid fa-leaf"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="d-block">{{ $plant->name }}</strong>
                            <small class="text-muted fst-italic">{{ $plant->scientific_name ?: 'Taxonomy pending' }}</small>
                        </td>
                        <td>
                            @if($plant->category)
                                <span class="badge bg-light text-dark">{{ $plant->category->name }}</span>
                            @else
                                <span class="text-muted small">Uncategorized</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success text-capitalize">{{ $plant->difficulty }}</span>
                        </td>
                        <td>
                            @if($plant->indoor) <span class="badge bg-info-subtle text-info">Indoor</span> @endif
                            @if($plant->outdoor) <span class="badge bg-warning-subtle text-warning">Outdoor</span> @endif
                        </td>
                        <td>
                            @if($plant->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($plant->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                            @else
                                <span class="badge bg-dark">Archived</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.plants.duplicate', $plant->id) }}" method="POST" class="d-inline" title="Duplicate Plant">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary" style="border-radius:8px">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.plants.edit', $plant->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.plants.destroy', $plant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to soft delete this plant?')">
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
                        <td colspan="7" class="text-center py-4 text-muted">No plant profiles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $plants->links() }}
    </div>
</div>
@endsection
