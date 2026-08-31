@extends('layouts.app')

@section('title', '419 Page Expired — Plantaric')

@section('content')
<div class="container section">
    <div class="bg-white border p-5 text-center mx-auto" style="border-radius:28px;box-shadow:var(--shadow);max-width:600px">
        <span class="brand-mark mx-auto mb-3" style="width:64px;height:64px;font-size:28px"><i class="fa-solid fa-clock-rotate-left"></i></span>
        <h1 style="font-family:'Playfair Display',serif;font-weight:700" class="mb-2">419</h1>
        <h3 class="fw-bold mb-2">Page Expired</h3>
        <p class="text-muted mb-4">Your session has expired due to inactivity. Please refresh the page and try again.</p>
        <a href="{{ route('frontend.home') }}" class="btn btn-primary px-4 py-3 fw-bold" style="border-radius:14px;background:var(--green-900);color:#fff">Return to Homepage <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>
</div>
@endsection
