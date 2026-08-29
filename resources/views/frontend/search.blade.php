@extends('layouts.app')

@section('title', "Search Results for '{$query}' — Plantora")

@section('content')
<div class="container section">
    <div class="mb-5">
        <h2 style="font-family:'Playfair Display',serif;font-weight:700" class="mb-2">Search Results</h2>
        @if($query)
            <p class="text-muted">Showing results for: <strong class="text-dark">"{{ $query }}"</strong></p>
        @else
            <p class="text-muted">Please enter a search term to discover plants, categories, and plant doctor solutions.</p>
        @endif
    </div>

    <!-- Plant Results -->
    @if(isset($plants) && $plants->count() > 0)
        <div class="mb-5">
            <h3 class="fw-bold mb-3" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-leaf text-success me-2"></i> Plant Encyclopedia Matches</h3>
            <div class="product-grid mb-4">
                @foreach($plants as $plant)
                    <article class="product-card">
                        <div class="product-media">
                            <img src="{{ $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85' }}" alt="{{ $plant->name }}">
                        </div>
                        <div class="product-body">
                            <h4 class="fw-bold mb-1" style="font-size:16px"><a href="{{ route('plants.show', $plant->slug) }}">{{ $plant->name }}</a></h4>
                            <p class="text-muted small fst-italic mb-3">{{ $plant->scientific_name }}</p>
                            <a href="{{ route('plants.show', $plant->slug) }}" class="btn btn-outline-success w-100" style="border-radius:10px;font-weight:700">View Care Guide</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Problem Results -->
    @if(isset($problems) && $problems->count() > 0)
        <div class="mb-5">
            <h3 class="fw-bold mb-3" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-user-doctor text-warning me-2"></i> Plant Doctor Matches</h3>
            <div class="row g-4">
                @foreach($problems as $prob)
                    <div class="col-md-6 col-lg-4">
                        <div class="p-4 bg-white border rounded-4 shadow-sm">
                            <span class="badge bg-light text-dark text-capitalize mb-2">{{ $prob->problem_type }}</span>
                            <h4 class="fw-bold mb-2"><a href="{{ route('problems.show', $prob->slug) }}" class="text-dark text-decoration-none">{{ $prob->name }}</a></h4>
                            <p class="text-muted small mb-3">{{ Str::limit($prob->short_description, 90) }}</p>
                            <a href="{{ route('problems.show', $prob->slug) }}" class="fw-bold text-success text-decoration-none">
                                View Diagnosis & Treatment <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if((!isset($plants) || $plants->count() === 0) && (!isset($problems) || $problems->count() === 0))
        <div class="bg-white border p-5 text-center rounded-4 shadow-sm">
            <i class="fa-solid fa-magnifying-glass fa-3x mb-3 text-secondary opacity-50"></i>
            <h4>No matching plants or health solutions found.</h4>
            <p class="text-muted">Try searching with a broader keyword like "Monstera", "Yellow Leaves", or "Indoor".</p>
            <a href="{{ route('plants.index') }}" class="btn btn-primary mt-2" style="border-radius:12px;background:var(--green-900)">Browse All Plants</a>
        </div>
    @endif
</div>
@endsection
