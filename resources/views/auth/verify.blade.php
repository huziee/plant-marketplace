@extends('layouts.app')

@section('title', 'Verify Email — Plantora')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white border p-4 p-md-5 text-center" style="border-radius:28px;box-shadow:var(--shadow)">
                <span class="brand-mark mx-auto mb-3" style="width:54px;height:54px;font-size:24px"><i class="fa-regular fa-envelope"></i></span>
                <h2 style="font-family:'Playfair Display',serif;font-weight:700" class="mb-2">Verify Your Email</h2>
                <p class="text-muted small mb-4">Before proceeding, please check your email inbox for a verification link.</p>

                @if (session('resent'))
                    <div class="alert alert-success border-0 small mb-4" style="border-radius:12px;background:#e8f3ea;color:#1c4d31" role="alert">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <p class="small text-muted mb-4">If you did not receive the email, click the button below to request another.</p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3" style="border-radius:14px;background:var(--green-900);color:#fff">Resend Verification Email</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
