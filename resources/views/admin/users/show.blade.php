@extends('layouts.admin')

@section('title', 'User Details — ' . $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">User Details</h2>
        <p class="text-muted mb-0" style="font-size:14px">Viewing profile information for #{{ $user->id }}.</p>
    </div>
    <div>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm me-2"><i class="fa-solid fa-pen me-1"></i> Edit User</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="card-custom" style="max-width:700px">
    <div class="d-flex align-items-center gap-4 border-bottom pb-4 mb-4">
        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle" style="width:80px;height:80px;object-fit:cover">
        <div>
            <h3 style="font-weight:700;margin:0">{{ $user->name }}</h3>
            <div class="text-muted" style="font-size:14px">{{ $user->email }}</div>
            <div class="mt-2">
                <span class="badge bg-light text-dark border me-1">{{ ucfirst($user->role) }}</span>
                @if($user->status === 'active')
                    <span class="badge bg-success-subtle text-success">Active</span>
                @else
                    <span class="badge bg-danger-subtle text-danger">{{ ucfirst($user->status) }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-6">
            <div class="text-muted small fw-bold">FIRST NAME</div>
            <div style="font-size:15px;font-weight:600">{{ $user->first_name }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small fw-bold">LAST NAME</div>
            <div style="font-size:15px;font-weight:600">{{ $user->last_name }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small fw-bold">PHONE</div>
            <div style="font-size:15px;font-weight:600">{{ $user->phone ?? 'Not provided' }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small fw-bold">EMAIL VERIFIED AT</div>
            <div style="font-size:15px;font-weight:600">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y H:i') : 'Unverified' }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small fw-bold">REGISTERED DATE</div>
            <div style="font-size:15px;font-weight:600">{{ $user->created_at->format('M d, Y H:i A') }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small fw-bold">LAST UPDATED</div>
            <div style="font-size:15px;font-weight:600">{{ $user->updated_at->format('M d, Y H:i A') }}</div>
        </div>
    </div>
</div>
@endsection
