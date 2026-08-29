@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">Newsletter Subscribers</h2>
        <p class="text-muted mb-0" style="font-size:14px">Manage email subscribers collected from Plantora newsletter forms.</p>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card-custom mb-4">
    <form action="{{ route('admin.subscribers.index') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-md-8">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search subscribers by email...">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="unsubscribed" {{ request('status') === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-success w-100 fw-bold"><i class="fa-solid fa-search"></i></button>
        </div>
    </form>
</div>

<!-- Subscribers Table -->
<div class="card-custom">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr style="font-size:12px;color:var(--muted)">
                    <th>ID</th>
                    <th>EMAIL ADDRESS</th>
                    <th>STATUS</th>
                    <th>SOURCE</th>
                    <th>SUBSCRIBED DATE</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr>
                        <td>#{{ $subscriber->id }}</td>
                        <td style="font-weight:700">{{ $subscriber->email }}</td>
                        <td>
                            @if($subscriber->status === 'active')
                                <span class="badge bg-success-subtle text-success">Active</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">Unsubscribed</span>
                            @endif
                        </td>
                        <td style="font-size:13px"><span class="badge bg-light text-dark border">{{ $subscriber->source ?? 'website' }}</span></td>
                        <td style="font-size:13px" class="text-muted">{{ $subscriber->subscribed_at ? $subscriber->subscribed_at->format('M d, Y H:i') : $subscriber->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No subscribers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($subscribers->hasPages())
        <div class="mt-4">
            {{ $subscribers->links() }}
        </div>
    @endif
</div>
@endsection
