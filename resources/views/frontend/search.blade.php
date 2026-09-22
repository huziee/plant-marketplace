@extends('layouts.app')

@section('title', "Search Results for '{$query}' — Plantaric")

@section('content')
<div class="container section">
    <div class="mb-5">
        <h2 style="font-family:'Playfair Display',serif;font-weight:700" class="mb-2">Search Results</h2>
        @if($query)
            <p class="text-muted">Showing results for: <strong class="text-dark">"{{ $query }}"</strong></p>
        @else
            <p class="text-muted">Please enter a search term to discover plants, categories, products, and articles.</p>
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
                            <img src="{{ $plant->featuredImage ? asset('storage/' . $plant->featuredImage->file_path) : asset('images/placeholders/plant_placeholder.jpg') }}" alt="{{ $plant->name }}">
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

    @if(!isset($plants) || $plants->count() === 0)
        <div class="bg-white border p-5 text-center rounded-4 shadow-sm">
            <i class="fa-solid fa-magnifying-glass fa-3x mb-3 text-secondary opacity-50"></i>
            <h4>No matching plants or care guides found.</h4>
            <p class="text-muted">Try searching with a broader keyword like "Monstera", "Snake Plant", or "Indoor".</p>
            <a href="{{ route('plants.index') }}" class="btn btn-primary mt-2" style="border-radius:12px;background:var(--green-900)">Browse All Plants</a>
        </div>
    @endif
</div>
@endsection
