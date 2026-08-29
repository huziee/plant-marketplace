@extends('layouts.admin')

@section('title', 'Product Reviews - Plantora Admin')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-star text-warning me-2"></i>Product Reviews Moderation</h1>
    <p class="text-muted small mb-0">Approve or reject customer reviews and ratings.</p>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="row g-3">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Moderation</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                        <th class="ps-4">Product</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Verified</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="ps-4 font-weight-bold">{{ $review->product ? $review->product->name : 'Deleted Product' }}</td>
                            <td>{{ $review->user ? $review->user->name : 'Anonymous' }}</td>
                            <td>
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </span>
                            </td>
                            <td>
                                <strong>{{ $review->title }}</strong>
                                <p class="mb-0 small text-muted">{{ Str::limit($review->review, 100) }}</p>
                            </td>
                            <td>
                                @if($review->verified_purchase)
                                    <span class="badge bg-success-subtle text-success border border-success"><i class="fa-solid fa-check me-1"></i> Verified</span>
                                @else
                                    <span class="text-muted small">No</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $review->status === 'approved' ? 'bg-success' : ($review->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ ucfirst($review->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                @if($review->status !== 'approved')
                                    <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-sm btn-outline-success me-1"><i class="fa-solid fa-check"></i> Approve</button>
                                    </form>
                                @endif
                                @if($review->status !== 'rejected')
                                    <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-sm btn-outline-warning me-1"><i class="fa-solid fa-ban"></i> Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No product reviews submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($reviews->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
