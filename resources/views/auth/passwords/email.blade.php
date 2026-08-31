@extends('layouts.app')

@section('title', 'Reset Password — Plantaric')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white border p-4 p-md-5" style="border-radius:28px;box-shadow:var(--shadow)">
                <div class="text-center mb-4">
                    <span class="brand-mark mx-auto mb-3" style="width:48px;height:48px;font-size:22px"><i class="fa-solid fa-key"></i></span>
                    <h2 style="font-family:'Playfair Display',serif;font-weight:700">Reset Password</h2>
                    <p class="text-muted small mb-0">Enter your registered email to receive a password reset link.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success border-0 small mb-4" style="border-radius:12px;background:#e8f3ea;color:#1c4d31" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" style="height:50px;border-radius:14px" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3" style="border-radius:14px;background:var(--green-900);color:#fff">Send Password Reset Link</button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none small" style="color:var(--green-700)"><i class="fa-solid fa-arrow-left me-1"></i> Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
