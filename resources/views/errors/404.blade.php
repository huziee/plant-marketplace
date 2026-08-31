@extends('layouts.app')

@section('title', '404 Page Not Found — Plantaric')

@section('content')
<div class="container section">
    <div class="bg-white border p-5 text-center mx-auto" style="border-radius:28px;box-shadow:var(--shadow);max-width:600px">
        <span class="brand-mark mx-auto mb-3" style="width:64px;height:64px;font-size:28px"><i class="fa-solid fa-seedling"></i></span>
        <h1 style="font-family:'Playfair Display',serif;font-weight:700" class="mb-2">404</h1>
        <h3 class="fw-bold mb-2">Page Not Found</h3>
        <p class="text-muted mb-4">The plant guide, product, or page you were looking for might have been moved or does not exist.</p>
        <a href="{{ route('frontend.home') }}" class="btn btn-primary px-4 py-3 fw-bold" style="border-radius:14px;background:var(--green-900);color:#fff">Return to Homepage <i class="fa-solid fa-arrow-right ms-1"></i></a>
    </div>
</div>
@endsection
