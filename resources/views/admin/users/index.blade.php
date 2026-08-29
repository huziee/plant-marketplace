@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">User Management</h2>
        <p class="text-muted mb-0" style="font-size:14px">Search, filter, and edit user roles and account statuses.</p>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card-custom mb-4">
    <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-md-5">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-radius-sm" placeholder="Search by name, email, or phone...">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="nursery_owner" {{ request('role') === 'nursery_owner' ? 'selected' : '' }}>Nursery Owner</option>
                <option value="editor" {{ request('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                <option value="author" {{ request('role') === 'author' ? 'selected' : '' }}>Author</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-success w-100 fw-bold"><i class="fa-solid fa-filter"></i></button>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="card-custom">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr style="font-size:12px;color:var(--muted)">
                    <th>ID</th>
                    <th>USER</th>
                    <th>PHONE</th>
                    <th>ROLE</th>
                    <th>STATUS</th>
                    <th>JOINED</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $user->avatar_url }}" alt="" class="rounded-circle" style="width:40px;height:40px">
                                <div>
                                    <div style="font-size:14px;font-weight:700">{{ $user->name }}</div>
                                    <div class="text-muted" style="font-size:12px">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px">{{ $user->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success-subtle text-success">Active</span>
                            @elseif($user->status === 'inactive')
                                <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Suspended</span>
                            @endif
                        </td>
                        <td style="font-size:13px" class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-light border me-1" title="View Details"><i class="fa-regular fa-eye"></i></a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light border" title="Edit User"><i class="fa-solid fa-pen"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No users found matching your criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
