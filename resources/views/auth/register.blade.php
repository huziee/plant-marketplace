@extends('layouts.app')

@section('title', 'Register — Plantaric')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="bg-white border p-4 p-md-5" style="border-radius:28px;box-shadow:var(--shadow)">
                <div class="text-center mb-4">
                    <span class="brand-mark mx-auto mb-3" style="width:48px;height:48px;font-size:22px"><i class="fa-solid fa-seedling"></i></span>
                    <h2 style="font-family:'Playfair Display',serif;font-weight:700">Create Account</h2>
                    <p class="text-muted small mb-0">Join the Plantaric community of plant lovers and growers</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" style="height:50px;border-radius:14px" required autofocus>
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" style="height:50px;border-radius:14px" required>
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" style="height:50px;border-radius:14px" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Phone Number (Optional)</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" style="height:50px;border-radius:14px" placeholder="+92 300 1234567">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" style="height:50px;border-radius:14px" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" style="height:50px;border-radius:14px" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3" style="border-radius:14px;background:var(--green-900);color:#fff">Create Account <i class="fa-solid fa-arrow-right me-1"></i></button>
                </form>

                <div class="text-center mt-4 pt-3 border-top">
                    <span class="text-muted small">Already have an account?</span>
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none ms-1" style="color:var(--green-700)">Sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
