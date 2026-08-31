@extends('layouts.admin')

@section('title', 'Contact Messages - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-inbox text-success me-2"></i>Contact Messages</h1>
        <p class="text-muted small mb-0">Review and manage incoming customer inquiries and support requests.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.contact-messages.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search name, email, subject..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New Messages</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
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
                        <th class="ps-4">Sender Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Received Date</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr class="{{ $msg->status === 'new' ? 'fw-bold bg-light' : '' }}">
                            <td class="ps-4">
                                {{ $msg->name }}
                                @if($msg->status === 'new')
                                    <span class="badge bg-danger ms-1" style="font-size:9px">NEW</span>
                                @endif
                            </td>
                            <td><a href="mailto:{{ $msg->email }}" class="text-decoration-none text-dark">{{ $msg->email }}</a></td>
                            <td>{{ Str::limit($msg->subject, 40) }}</td>
                            <td>
                                @if($msg->status === 'new')
                                    <span class="badge bg-danger">New</span>
                                @elseif($msg->status === 'read')
                                    <span class="badge bg-info">Read</span>
                                @elseif($msg->status === 'replied')
                                    <span class="badge bg-success">Replied</span>
                                @else
                                    <span class="badge bg-secondary">Archived</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="btn btn-sm btn-outline-primary me-1" title="View Message">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                                <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" class="d-inline ajax-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Message"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No contact messages received yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($messages->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
