@extends('layouts.app')

@section('title', 'Login — Plantora')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white border p-4 p-md-5" style="border-radius:28px;box-shadow:var(--shadow)">
                <div class="text-center mb-4">
                    <span class="brand-mark mx-auto mb-3" style="width:48px;height:48px;font-size:22px"><i class="fa-solid fa-seedling"></i></span>
                    <h2 style="font-family:'Playfair Display',serif;font-weight:700">Welcome Back</h2>
                    <p class="text-muted small mb-0">Sign in to your Plantora account</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success border-0 small mb-4" style="border-radius:12px;background:#e8f3ea;color:#1c4d31">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" style="height:50px;border-radius:14px" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold small mb-0">Password</label>
                            <a href="{{ route('password.request') }}" class="small text-decoration-none" style="color:var(--green-700);font-weight:700">Forgot Password?</a>
                        </div>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" style="height:50px;border-radius:14px" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Remember me on this device</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3" style="border-radius:14px;background:var(--green-900);color:#fff">Sign In <i class="fa-solid fa-arrow-right me-1"></i></button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <span class="text-muted small">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none ms-1" style="color:var(--green-700)">Register now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
