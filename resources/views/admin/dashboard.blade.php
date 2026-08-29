@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">Dashboard</h2>
        <p class="text-muted mb-0" style="font-size:14px">Welcome back, {{ auth()->user()->first_name }}! Here is your real-time system summary.</p>
    </div>
    <span class="badge bg-success px-3 py-2" style="border-radius:999px;font-size:12px">System Online</span>
</div>

<!-- Metrics Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="card-custom text-center p-3 mb-0">
            <div class="text-muted" style="font-size:12px;font-weight:700">TOTAL USERS</div>
            <div style="font-size:28px;font-weight:800;color:var(--green-950)">{{ $stats['total_users'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card-custom text-center p-3 mb-0">
            <div class="text-muted" style="font-size:12px;font-weight:700">CUSTOMERS</div>
            <div style="font-size:28px;font-weight:800;color:var(--green-700)">{{ $stats['customers'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card-custom text-center p-3 mb-0">
            <div class="text-muted" style="font-size:12px;font-weight:700">NURSERY OWNERS</div>
            <div style="font-size:28px;font-weight:800;color:var(--green-900)">{{ $stats['nursery_owners'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card-custom text-center p-3 mb-0">
            <div class="text-muted" style="font-size:12px;font-weight:700">EDITORS / AUTHORS</div>
            <div style="font-size:28px;font-weight:800;color:var(--green-800)">{{ $stats['content_creators'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card-custom text-center p-3 mb-0">
            <div class="text-muted" style="font-size:12px;font-weight:700">MEDIA FILES</div>
            <div style="font-size:28px;font-weight:800;color:var(--green-950)">{{ $stats['media_files'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="card-custom text-center p-3 mb-0">
            <div class="text-muted" style="font-size:12px;font-weight:700">SUBSCRIBERS</div>
            <div style="font-size:28px;font-weight:800;color:var(--green-700)">{{ $stats['subscribers'] }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recently Registered Users -->
    <div class="col-lg-8">
        <div class="card-custom h-100 mb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 style="font-weight:700;margin:0">Recently Registered Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-link text-decoration-none" style="color:var(--green-700);font-weight:700">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="font-size:12px;color:var(--muted)">
                            <th>USER</th>
                            <th>ROLE</th>
                            <th>STATUS</th>
                            <th>JOINED</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $user->avatar_url }}" alt="" class="rounded-circle" style="width:32px;height:32px">
                                        <div>
                                            <div style="font-size:14px;font-weight:700">{{ $user->name }}</div>
                                            <div class="text-muted" style="font-size:12px">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $user->role }}</span></td>
                                <td>
                                    @if($user->status === 'active')
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">{{ ucfirst($user->status) }}</span>
                                    @endif
                                </td>
                                <td style="font-size:13px" class="text-muted">{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No users registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System Info -->
    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <h5 style="font-weight:700;margin-bottom:16px">Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light text-start border p-2 px-3 fw-bold" style="border-radius:12px;font-size:14px">
                    <i class="fa-solid fa-user-gear me-2 text-success"></i> Manage Users
                </a>
                <a href="{{ route('admin.media.index') }}" class="btn btn-light text-start border p-2 px-3 fw-bold" style="border-radius:12px;font-size:14px">
                    <i class="fa-regular fa-image me-2 text-primary"></i> Upload Media
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-light text-start border p-2 px-3 fw-bold" style="border-radius:12px;font-size:14px">
                    <i class="fa-solid fa-sliders me-2 text-warning"></i> Website Settings
                </a>
            </div>
        </div>

        <div class="card-custom mb-0">
            <h5 style="font-weight:700;margin-bottom:16px">System Information</h5>
            <div style="font-size:13px">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Laravel Version</span>
                    <strong>v{{ $systemInfo['laravel_version'] }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">PHP Version</span>
                    <strong>v{{ $systemInfo['php_version'] }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Database Connection</span>
                    <strong class="text-uppercase">{{ $systemInfo['db_driver'] }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Environment</span>
                    <strong class="text-uppercase">{{ $systemInfo['environment'] }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
