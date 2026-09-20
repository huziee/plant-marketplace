@extends('layouts.admin')

@section('title', 'Product Reviews - Plantaric Admin')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-star text-warning me-2"></i>Product Reviews Moderation</h1>
    <p class="text-muted small mb-0">Approve or reject customer reviews and ratings.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold">TOTAL REVIEWS</div>
                    <div class="h3 fw-bold mb-0 text-dark">{{ number_format($totalCount) }}</div>
                </div>
                <div class="p-3 bg-light rounded-circle text-primary"><i class="fa-solid fa-comments fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold">PENDING MODERATION</div>
                    <div class="h3 fw-bold mb-0 text-warning">{{ number_format($pendingCount) }}</div>
                </div>
                <div class="p-3 bg-warning-subtle text-warning rounded-circle"><i class="fa-solid fa-clock fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold">APPROVED REVIEWS</div>
                    <div class="h3 fw-bold mb-0 text-success">{{ number_format($approvedCount) }}</div>
                </div>
                <div class="p-3 bg-success-subtle text-success rounded-circle"><i class="fa-solid fa-check-circle fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-bold">AVG RATING</div>
                    <div class="h3 fw-bold mb-0 text-dark">{{ $avgRating }} <span class="text-warning fs-6">★</span></div>
                </div>
                <div class="p-3 bg-light text-warning rounded-circle"><i class="fa-solid fa-star fa-lg"></i></div>
            </div>
        </div>
    </div>
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
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    @if($review->product?->featuredImage)
                                        <img src="{{ asset('storage/' . $review->product->featuredImage->file_path) }}" alt="{{ $review->product->name }}" class="rounded" style="width:40px;height:40px;object-fit:cover">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width:40px;height:40px;font-size:12px">
                                            <i class="fa-solid fa-box"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="d-block text-dark">{{ $review->product ? $review->product->name : 'Deleted Product' }}</strong>
                                    </div>
                                </div>
                            </td>
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
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $review->status === 'approved' ? 'bg-success' : ($review->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ ucfirst($review->status) }}
                                    </span>
                                    <select class="form-select form-select-sm ajax-review-status-select" data-review-id="{{ $review->id }}" style="width:110px;font-size:12px">
                                        <option value="pending" {{ $review->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $review->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $review->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
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
