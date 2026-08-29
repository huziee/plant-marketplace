@extends('layouts.admin')

@section('title', 'Content Tags')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Content Tags</h2>
        <p class="text-muted small mb-0">Manage keywords and tags for taxonomy filtering.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom">
            <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Create Tag</h5>
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Tag Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required placeholder="e.g. Monstera">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @error
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Slug (Optional)</label>
                    <input type="text" name="slug" class="form-control" placeholder="e.g. monstera">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100" style="border-radius:12px;font-weight:700">Save Tag <i class="fa-solid fa-plus ms-1"></i></button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-custom p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tag Name</th>
                            <th>Slug</th>
                            <th>Associated Posts</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $tag->name }}</td>
                                <td><code>{{ $tag->slug }}</code></td>
                                <td class="fw-bold">{{ $tag->posts_count }}</td>
                                <td>
                                    <span class="badge {{ $tag->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($tag->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete tag?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No content tags created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
