@extends('layouts.admin')

@section('title', 'Edit User #' . $user->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">Edit User Profile</h2>
        <p class="text-muted mb-0" style="font-size:14px">Update user details, assign roles, and manage access statuses.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Back to Users</a>
</div>

<div class="card-custom" style="max-width:700px">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold small">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control @error('first_name') is-invalid @enderror" required>
                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control @error('last_name') is-invalid @enderror" required>
                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold small">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold small">User Role</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="nursery_owner" {{ old('role', $user->role) === 'nursery_owner' ? 'selected' : '' }}>Nursery Owner</option>
                    <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="author" {{ old('role', $user->role) === 'author' ? 'selected' : '' }}>Author</option>
                </select>
                @if(auth()->id() === $user->id)
                    <input type="hidden" name="role" value="admin">
                    <small class="text-muted d-block mt-1">You cannot change your own admin role.</small>
                @endif
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small">Account Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                @if(auth()->id() === $user->id)
                    <input type="hidden" name="status" value="active">
                    <small class="text-muted d-block mt-1">You cannot deactivate your own account.</small>
                @endif
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        <hr class="my-4 text-muted">
        <h6 class="fw-bold mb-2"><i class="fa-solid fa-key me-1 text-success"></i> Change Password (Optional)</h6>
        <p class="text-muted small mb-3">Leave blank if you do not wish to change this user's password.</p>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold small">New Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min 8 characters">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold small">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
            </div>
        </div>

        <button type="submit" class="btn btn-success fw-bold px-4"><i class="fa-solid fa-save me-1"></i> Update User</button>
    </form>
</div>
@endsection
