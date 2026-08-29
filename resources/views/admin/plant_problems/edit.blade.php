@extends('layouts.admin')

@section('title', 'Edit Plant Problem')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.plant-problems.index') }}" class="text-decoration-none text-muted small fw-bold">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Problems
    </a>
    <h2 class="fw-bold mt-2" style="font-family:'Playfair Display',serif">Edit Problem: {{ $plantProblem->name }}</h2>
</div>

<form action="{{ route('admin.plant-problems.update', $plantProblem->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Problem Information</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Problem Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $plantProblem->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Slug (URL identifier)</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $plantProblem->slug) }}">
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Type <span class="text-danger">*</span></label>
                    <select name="problem_type" class="form-select">
                        <option value="disease" {{ old('problem_type', $plantProblem->problem_type) === 'disease' ? 'selected' : '' }}>Fungal / Bacterial Disease</option>
                        <option value="pest" {{ old('problem_type', $plantProblem->problem_type) === 'pest' ? 'selected' : '' }}>Pest / Insect Infestation</option>
                        <option value="watering" {{ old('problem_type', $plantProblem->problem_type) === 'watering' ? 'selected' : '' }}>Watering Issue (Over/Under)</option>
                        <option value="nutrient" {{ old('problem_type', $plantProblem->problem_type) === 'nutrient' ? 'selected' : '' }}>Nutrient Deficiency</option>
                        <option value="environment" {{ old('problem_type', $plantProblem->problem_type) === 'environment' ? 'selected' : '' }}>Environmental Stress</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Short Overview</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $plantProblem->short_description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Full Explanation</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $plantProblem->description) }}</textarea>
                </div>
            </div>

            <!-- Symptoms & Treatments Card -->
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Symptoms & Step-by-Step Treatment</h5>
                
                @php
                    $symptomsStr = $plantProblem->symptoms->pluck('symptom')->implode("\n");
                    $causesStr = $plantProblem->causes->pluck('cause')->implode("\n");
                    $treatmentsStr = $plantProblem->treatments->pluck('instruction')->implode("\n");
                    $preventionsStr = $plantProblem->preventions->pluck('instruction')->implode("\n");
                @endphp

                <div class="mb-4">
                    <label class="form-label fw-bold small">Symptoms (One per line)</label>
                    <textarea name="symptoms[]" class="form-control" rows="3">{{ old('symptoms.0', $symptomsStr) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Causes (One per line)</label>
                    <textarea name="causes[]" class="form-control" rows="3">{{ old('causes.0', $causesStr) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Treatment Instructions (One step per line)</label>
                    <textarea name="treatments[]" class="form-control" rows="4">{{ old('treatments.0', $treatmentsStr) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Prevention Measures (One per line)</label>
                    <textarea name="preventions[]" class="form-control" rows="3">{{ old('preventions.0', $preventionsStr) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Status & Severity</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $plantProblem->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $plantProblem->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Severity <span class="text-danger">*</span></label>
                    <select name="severity" class="form-select">
                        <option value="low" {{ old('severity', $plantProblem->severity) === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('severity', $plantProblem->severity) === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('severity', $plantProblem->severity) === 'high' ? 'selected' : '' }}>High (Urgent)</option>
                    </select>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" {{ old('is_featured', $plantProblem->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold small" for="isFeatured">Featured on Plant Doctor</label>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius:12px;background:var(--green-900)">
                    Update Problem Guide
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
