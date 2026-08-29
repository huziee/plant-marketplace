@extends('layouts.app')

@section('title', $seo['title'])
@section('meta_description', $seo['description'])

@section('content')
<!-- Breadcrumb Header -->
<div class="bg-light py-3 border-bottom">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 small fw-bold">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('problems.index') }}" class="text-decoration-none text-muted">Plant Problems</a></li>
        <li class="breadcrumb-item active text-success" aria-current="page">{{ $plantProblem->name }}</li>
      </ol>
    </nav>
  </div>
</div>

<section class="section py-5">
  <div class="container">
    <div class="max-w-900 mx-auto">
      <div class="d-flex align-items-center gap-2 mb-3">
        <span class="badge bg-success-subtle text-success text-uppercase">{{ $plantProblem->problem_type }}</span>
        @if($plantProblem->severity === 'high')
          <span class="badge bg-danger">High Severity</span>
        @else
          <span class="badge bg-warning text-dark">{{ ucfirst($plantProblem->severity) }} Severity</span>
        @endif
      </div>

      <h1 class="fw-bold mb-3" style="font-size:clamp(34px,4vw,52px);font-family:'Playfair Display',serif">{{ $plantProblem->name }}</h1>
      <p class="lead text-secondary mb-5">{{ $plantProblem->short_description }}</p>

      <div class="row g-4 mb-5">
        <!-- Symptoms Column -->
        @if($plantProblem->symptoms->count() > 0)
          <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 border h-100 shadow-sm">
              <h4 class="fw-bold text-danger mb-3"><i class="fa-solid fa-triangle-exclamation me-2"></i> Key Symptoms</h4>
              <ul class="list-unstyled mb-0">
                @foreach($plantProblem->symptoms as $sym)
                  <li class="mb-2 d-flex align-items-start gap-2">
                    <i class="fa-solid fa-circle-notch text-danger mt-1" style="font-size:12px"></i>
                    <span>{{ $sym->symptom }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif

        <!-- Causes Column -->
        @if($plantProblem->causes->count() > 0)
          <div class="col-md-6">
            <div class="p-4 bg-white rounded-4 border h-100 shadow-sm">
              <h4 class="fw-bold text-warning mb-3"><i class="fa-solid fa-magnifying-glass me-2"></i> Probable Causes</h4>
              <ul class="list-unstyled mb-0">
                @foreach($plantProblem->causes as $cause)
                  <li class="mb-2 d-flex align-items-start gap-2">
                    <i class="fa-solid fa-circle-question text-warning mt-1" style="font-size:12px"></i>
                    <span>{{ $cause->cause }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        @endif
      </div>

      <!-- Step-by-Step Treatment -->
      @if($plantProblem->treatments->count() > 0)
        <div class="p-4 p-md-5 bg-white border rounded-4 shadow-sm mb-5">
          <h3 class="fw-bold text-success mb-4" style="font-family:'Playfair Display',serif"><i class="fa-solid fa-kit-medical me-2"></i> Step-by-Step Treatment Instructions</h3>
          
          <div class="d-flex flex-column gap-3">
            @foreach($plantProblem->treatments as $index => $treatment)
              <div class="d-flex gap-3 align-items-start p-3 rounded-3" style="background:var(--green-50);border:1px solid var(--line)">
                <div class="rounded-circle bg-success text-white fw-bold d-grid place-items-center flex-shrink-0" style="width:32px;height:32px;line-height:32px;text-align:center">
                  {{ $index + 1 }}
                </div>
                <div>
                  @if($treatment->title)
                    <strong class="d-block mb-1 fs-6">{{ $treatment->title }}</strong>
                  @endif
                  <p class="text-muted mb-0">{{ $treatment->instruction }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Prevention Section -->
      @if($plantProblem->preventions->count() > 0)
        <div class="p-4 bg-white border rounded-4 shadow-sm mb-5">
          <h4 class="fw-bold text-success mb-3"><i class="fa-solid fa-shield-halved me-2"></i> How to Prevent This Problem</h4>
          <ul class="mb-0">
            @foreach($plantProblem->preventions as $prev)
              <li class="text-muted mb-2">{{ $prev->instruction }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Safety Disclaimer -->
      <div class="p-4 rounded-4 mb-5" style="background:#fffbe6;border:1px solid #ffe58f">
        <div class="d-flex gap-3">
          <i class="fa-solid fa-shield-cat text-warning fa-2x"></i>
          <div>
            <h6 class="fw-bold text-warning-emphasis mb-1">Safety & Responsible Use Disclaimer</h6>
            <p class="small text-secondary mb-0">Always read and follow safety instructions and product labels when applying plant care products, neem oil, or organic remedies. Keep out of reach of children and pets.</p>
          </div>
        </div>
      </div>

      <!-- Plants Commonly Affected -->
      @if($plantProblem->plants->count() > 0)
        <div class="pt-4 border-top">
          <h3 class="fw-bold mb-4" style="font-family:'Playfair Display',serif">Plants Commonly Affected</h3>
          <div class="product-grid">
            @foreach($plantProblem->plants as $affectedPlant)
              <article class="product-card">
                <div class="product-media">
                  <img src="{{ $affectedPlant->featuredImage ? asset('storage/' . $affectedPlant->featuredImage->file_path) : 'https://images.unsplash.com/photo-1614594575810-7a6f1ee5f7f4?auto=format&fit=crop&w=700&q=85' }}" alt="{{ $affectedPlant->name }}">
                </div>
                <div class="product-body">
                  <h4 class="fw-bold mb-1" style="font-size:16px"><a href="{{ route('plants.show', $affectedPlant->slug) }}">{{ $affectedPlant->name }}</a></h4>
                  <p class="text-muted small fst-italic mb-2">{{ $affectedPlant->scientific_name }}</p>
                  <a href="{{ route('plants.show', $affectedPlant->slug) }}" class="btn btn-sm btn-outline-success w-100" style="border-radius:10px">View Care Guide</a>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
@endsection
