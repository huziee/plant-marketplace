@extends('layouts.app')

@section('title', 'Set New Password — Plantora')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white border p-4 p-md-5" style="border-radius:28px;box-shadow:var(--shadow)">
                <div class="text-center mb-4">
                    <span class="brand-mark mx-auto mb-3" style="width:48px;height:48px;font-size:22px"><i class="fa-solid fa-lock"></i></span>
                    <h2 style="font-family:'Playfair Display',serif;font-weight:700">Set New Password</h2>
                    <p class="text-muted small mb-0">Create a secure new password for your Plantora account.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror" style="height:50px;border-radius:14px" required readonly>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">New Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" style="height:50px;border-radius:14px" required autofocus>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" style="height:50px;border-radius:14px" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3" style="border-radius:14px;background:var(--green-900);color:#fff">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
