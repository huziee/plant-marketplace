@extends('layouts.admin')

@section('title', 'Content Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Content Categories</h2>
        <p class="text-muted small mb-0">Organize articles, guides, and news into topic categories.</p>
    </div>
    <a href="{{ route('admin.content-categories.create') }}" class="btn btn-success" style="border-radius:12px"><i class="fa-solid fa-plus me-1"></i> Add Content Category</a>
</div>

<div class="card-custom p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Category Name</th>
                    <th>Slug</th>
                    <th>Applicable Type</th>
                    <th>Parent Category</th>
                    <th>Posts Count</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $cat->name }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td><span class="badge bg-dark text-uppercase">{{ $cat->type }}</span></td>
                        <td>{{ $cat->parent?->name ?: 'Root Category' }}</td>
                        <td class="fw-bold">{{ $cat->posts_count }}</td>
                        <td>
                            <span class="badge {{ $cat->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($cat->status) }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.content-categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.content-categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this content category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No content categories created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
