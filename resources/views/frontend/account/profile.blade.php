@extends('layouts.app')

@section('title', 'My Profile & Account Settings - Plantaric')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="h2 fw-bold text-dark mb-1">Account Settings</h1>
                <p class="text-muted small mb-0">Manage your profile details, personal preferences, and security settings.</p>
            </div>
            @if(in_array($user->role, ['admin', 'editor', 'author']))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fa-solid fa-gauge me-1 text-success"></i> Access Control Panel
                </a>
            @endif
        </div>
    </div>
</div>

<div class="container py-3 mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> Please correct the errors below before saving.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body text-center p-4 bg-white border-bottom">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm border mb-3" style="width:90px;height:90px;object-fit:cover">
                    <h5 class="fw-bold mb-1 text-dark">{{ $user->name }}</h5>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>
                    
                    @if($user->role === 'admin')
                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-pill small text-uppercase">
                            <i class="fa-solid fa-user-shield me-1"></i> Administrator
                        </span>
                    @elseif($user->role === 'editor')
                        <span class="badge bg-purple text-white px-3 py-1 rounded-pill small text-uppercase" style="background:#6b21a8">
                            <i class="fa-solid fa-pen-nib me-1"></i> Content Editor
                        </span>
                    @elseif($user->role === 'author')
                        <span class="badge bg-info-subtle text-info border border-info px-3 py-1 rounded-pill small text-uppercase">
                            <i class="fa-solid fa-feather-pointed me-1"></i> Botanical Author
                        </span>
                    @elseif($user->role === 'nursery_owner')
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill small text-uppercase">
                            <i class="fa-solid fa-store me-1"></i> Nursery Owner
                        </span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-1 rounded-pill small text-uppercase">
                            <i class="fa-solid fa-user me-1"></i> Plant Enthusiast
                        </span>
                    @endif
                </div>
                <div class="list-group list-group-flush border-0">
                    <a href="{{ route('frontend.account.profile') }}" class="list-group-item list-group-item-action active fw-bold py-3">
                        <i class="fa-regular fa-id-card me-2"></i> Profile & Info
                    </a>
                    <a href="{{ route('frontend.account.dashboard') }}" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('frontend.account.orders') }}" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-box me-2"></i> My Orders
                    </a>
                    <a href="{{ route('frontend.account.addresses') }}" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-location-dot me-2"></i> Saved Addresses
                    </a>
                    <a href="{{ route('frontend.account.password') }}" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-key me-2"></i> Security & Password
                    </a>
                    <a href="{{ route('frontend.account.wishlist') }}" class="list-group-item list-group-item-action py-3">
                        <i class="fa-solid fa-heart me-2"></i> Saved Wishlist
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            <form action="{{ route('frontend.account.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- 1. General Profile Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa-regular fa-user text-success me-2"></i> Personal Profile Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Avatar Section -->
                        <div class="d-flex align-items-center gap-4 mb-4 pb-4 border-bottom flex-wrap">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm border" style="width:80px;height:80px;object-fit:cover">
                            <div>
                                <label for="avatar" class="form-label fw-bold text-dark mb-1">Profile Avatar / Photo</label>
                                <input type="file" name="avatar" id="avatar" class="form-control form-control-sm @error('avatar') is-invalid @enderror" accept="image/*">
                                <div class="form-text">Allowed formats: JPG, PNG, WEBP, GIF. Max file size: 2MB.</div>
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-bold text-dark">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control @error('first_name') is-invalid @enderror" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-bold text-dark">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control @error('last_name') is-invalid @enderror" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold text-dark">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold text-dark">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror" placeholder="+92 300 0000000">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Role-Specific Profile Settings Card -->
                @if(in_array($user->role, ['admin', 'editor', 'author']))
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-feather-pointed text-success me-2"></i> Editorial & Author Bio Settings</h5>
                            <a href="{{ route('authors.show', $user->id) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill">
                                <i class="fa-solid fa-eye me-1"></i> Public Author Page
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-4">Your bio and social profile information will be displayed on your published articles, plant care guides, and public author profile page.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="job_title" class="form-label fw-bold text-dark">Professional Title / Designation</label>
                                    <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $user->authorProfile?->job_title) }}" class="form-control @error('job_title') is-invalid @enderror" placeholder="e.g. Senior Botanical Researcher & Plant Writer">
                                    @error('job_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="website" class="form-label fw-bold text-dark">Personal / Business Website</label>
                                    <input type="url" name="website" id="website" value="{{ old('website', $user->authorProfile?->website) }}" class="form-control @error('website') is-invalid @enderror" placeholder="https://example.com">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="bio" class="form-label fw-bold text-dark">Author Biography</label>
                                    <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" placeholder="Write a brief overview of your background in botany, horticulture, or plant cultivation...">{{ old('bio', $user->authorProfile?->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="linkedin" class="form-label fw-bold text-dark"><i class="fa-brands fa-linkedin text-primary me-1"></i> LinkedIn Profile</label>
                                    <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', $user->authorProfile?->linkedin) }}" class="form-control" placeholder="https://linkedin.com/in/username">
                                </div>

                                <div class="col-md-4">
                                    <label for="facebook" class="form-label fw-bold text-dark"><i class="fa-brands fa-facebook text-primary me-1"></i> Facebook Profile</label>
                                    <input type="text" name="facebook" id="facebook" value="{{ old('facebook', $user->authorProfile?->facebook) }}" class="form-control" placeholder="https://facebook.com/username">
                                </div>

                                <div class="col-md-4">
                                    <label for="instagram" class="form-label fw-bold text-dark"><i class="fa-brands fa-instagram text-danger me-1"></i> Instagram Handle</label>
                                    <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $user->authorProfile?->instagram) }}" class="form-control" placeholder="@username">
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($user->role === 'nursery_owner')
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-store text-success me-2"></i> Nursery Partner Business Settings</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="p-3 bg-light border rounded-3 mb-3">
                                <strong class="d-block text-dark mb-1"><i class="fa-solid fa-circle-info text-success me-1"></i> Marketplace Partner Status: Active</strong>
                                <span class="small text-muted">As a registered Nursery Partner, your inventory, plant product listings, and order fulfillments are managed under your seller credentials.</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light border">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div>
                                    <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-shield-halved text-success me-2"></i> Account Security & Password</h6>
                                    <span class="small text-muted">Keep your password strong and secure to safeguard your purchases and addresses.</span>
                                </div>
                                <a href="{{ route('frontend.account.password') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold">
                                    Change Password <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="d-flex justify-content-end gap-3 mb-4">
                    <a href="{{ route('frontend.account.dashboard') }}" class="btn btn-outline-secondary px-4 rounded-3">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 rounded-3 fw-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Profile Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
