@extends('layouts.admin')

@section('title', 'Create Plant Profile')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.plants.index') }}" class="text-decoration-none text-muted small fw-bold">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Plant Encyclopedia
    </a>
    <h2 class="fw-bold mt-2" style="font-family:'Playfair Display',serif">Create Plant Profile</h2>
</div>

<form action="{{ route('admin.plants.store') }}" method="POST">
    @csrf
    
    <!-- Tabbed Navigation -->
    <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="plantTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active fw-bold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab"><i class="fa-solid fa-leaf me-1"></i> General</button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-bold" id="care-tab" data-bs-toggle="tab" data-bs-target="#care" type="button" role="tab"><i class="fa-solid fa-droplet me-1"></i> Care Information</button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-bold" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab"><i class="fa-solid fa-ruler-combined me-1"></i> Characteristics</button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-bold" id="problems-tab" data-bs-toggle="tab" data-bs-target="#problems" type="button" role="tab"><i class="fa-solid fa-user-doctor me-1"></i> Common Problems</button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab"><i class="fa-solid fa-magnifying-glass me-1"></i> SEO</button>
        </li>
    </ul>

    <div class="tab-content" id="plantTabContent">
        <!-- GENERAL TAB -->
        <div class="tab-pane fade show active" id="general" role="tabpanel">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card card-custom">
                        <h5 class="fw-bold mb-3">Plant Identification</h5>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Plant Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Scientific Name</label>
                                <input type="text" name="scientific_name" class="form-control" value="{{ old('scientific_name') }}" placeholder="e.g. Monstera deliciosa">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Family</label>
                                <input type="text" name="family" class="form-control" value="{{ old('family') }}" placeholder="e.g. Araceae">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Genus</label>
                                <input type="text" name="genus" class="form-control" value="{{ old('genus') }}" placeholder="e.g. Monstera">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Species</label>
                                <input type="text" name="species" class="form-control" value="{{ old('species') }}" placeholder="e.g. deliciosa">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Local / Common Name</label>
                                <input type="text" name="local_name" class="form-control" value="{{ old('local_name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Urdu Name</label>
                                <input type="text" name="urdu_name" class="form-control" value="{{ old('urdu_name') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Short Overview</label>
                            <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Detailed Botanical Description</label>
                            <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-custom">
                        <h5 class="fw-bold mb-3">Category & Status</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Plant Category</label>
                            <select name="plant_category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('plant_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Care Difficulty <span class="text-danger">*</span></label>
                            <select name="difficulty" class="form-select">
                                <option value="easy" {{ old('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="moderate" {{ old('difficulty') === 'moderate' ? 'selected' : '' }}>Moderate</option>
                                <option value="advanced" {{ old('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced / Expert</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Growth Rate <span class="text-danger">*</span></label>
                            <select name="growth_rate" class="form-select">
                                <option value="slow" {{ old('growth_rate') === 'slow' ? 'selected' : '' }}>Slow</option>
                                <option value="medium" {{ old('growth_rate', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="fast" {{ old('growth_rate') === 'fast' ? 'selected' : '' }}>Fast</option>
                            </select>
                        </div>

                        <hr>

                        <div class="form-check mb-2">
                            <input type="checkbox" name="indoor" value="1" class="form-check-input" id="indoorCheck" {{ old('indoor', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="indoorCheck">Indoor Suitable</label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" name="outdoor" value="1" class="form-check-input" id="outdoorCheck" {{ old('outdoor') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="outdoorCheck">Outdoor Suitable</label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" name="pet_safe" value="1" class="form-check-input" id="petCheck" {{ old('pet_safe', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="petCheck">Pet Safe (Non-Toxic)</label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="air_purifying" value="1" class="form-check-input" id="airCheck" {{ old('air_purifying') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="airCheck">Air Purifying</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius:12px;background:var(--green-900)">
                            Save Plant Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARE TAB -->
        <div class="tab-pane fade" id="care" role="tabpanel">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Light & Water Requirements</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Sunlight Requirement</label>
                        <select name="care[sunlight_level]" class="form-select">
                            @foreach(\App\Models\PlantCare::sunlightLabels() as $key => $label)
                                <option value="{{ $key }}" {{ old('care.sunlight_level') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Watering Frequency</label>
                        <select name="care[watering_frequency]" class="form-select">
                            @foreach(\App\Models\PlantCare::wateringLabels() as $key => $label)
                                <option value="{{ $key }}" {{ old('care.watering_frequency') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Watering Guidance Notes</label>
                        <textarea name="care[watering_description]" class="form-control" rows="2" placeholder="e.g. Water when top 2-3cm of soil is dry.">{{ old('care.watering_description') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Sunlight Guidance Notes</label>
                        <textarea name="care[sunlight_description]" class="form-control" rows="2" placeholder="e.g. Thrives in bright indirect sunlight. Avoid direct midday sun.">{{ old('care.sunlight_description') }}</textarea>
                    </div>
                </div>

                <h5 class="fw-bold mb-3 mt-4">Soil & Environment</h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Soil Type</label>
                        <input type="text" name="care[soil_type]" class="form-control" value="{{ old('care.soil_type') }}" placeholder="e.g. Well-draining peat mix with perlite">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Min Soil pH</label>
                        <input type="number" step="0.1" name="care[soil_ph_min]" class="form-control" value="{{ old('care.soil_ph_min', 5.5) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Max Soil pH</label>
                        <input type="number" step="0.1" name="care[soil_ph_max]" class="form-control" value="{{ old('care.soil_ph_max', 7.0) }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Min Temp (°C)</label>
                        <input type="number" name="care[temperature_min]" class="form-control" value="{{ old('care.temperature_min', 15) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Max Temp (°C)</label>
                        <input type="number" name="care[temperature_max]" class="form-control" value="{{ old('care.temperature_max', 30) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Min Humidity (%)</label>
                        <input type="number" name="care[humidity_min]" class="form-control" value="{{ old('care.humidity_min', 40) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Max Humidity (%)</label>
                        <input type="number" name="care[humidity_max]" class="form-control" value="{{ old('care.humidity_max', 70) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Care Tips & Extra Notes</label>
                    <textarea name="care[care_tips]" class="form-control" rows="3">{{ old('care.care_tips') }}</textarea>
                </div>
            </div>
        </div>

        <!-- CHARACTERISTICS TAB -->
        <div class="tab-pane fade" id="specs" role="tabpanel">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Dimensions & Characteristics</h5>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Min Height</label>
                        <input type="number" step="0.1" name="mature_height_min" class="form-control" value="{{ old('mature_height_min') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Max Height</label>
                        <input type="number" step="0.1" name="mature_height_max" class="form-control" value="{{ old('mature_height_max') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Min Width</label>
                        <input type="number" step="0.1" name="mature_width_min" class="form-control" value="{{ old('mature_width_min') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Unit</label>
                        <select name="measurement_unit" class="form-select">
                            <option value="cm">cm</option>
                            <option value="m">meters</option>
                            <option value="inches">inches</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" name="flowering" value="1" class="form-check-input" id="floweringCheck" {{ old('flowering') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="floweringCheck">Flowering Plant</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" name="edible" value="1" class="form-check-input" id="edibleCheck" {{ old('edible') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="edibleCheck">Edible Leaves/Fruit</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="checkbox" name="medicinal" value="1" class="form-check-input" id="medicinalCheck" {{ old('medicinal') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="medicinalCheck">Medicinal Value</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COMMON PROBLEMS TAB -->
        <div class="tab-pane fade" id="problems" role="tabpanel">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Link Common Plant Problems</h5>
                <p class="text-muted small mb-3">Select known issues associated with this plant species.</p>

                <div class="row g-3">
                    @foreach($problems as $prob)
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light">
                                <div class="form-check">
                                    <input type="checkbox" name="problem_ids[]" value="{{ $prob->id }}" class="form-check-input" id="prob_{{ $prob->id }}">
                                    <label class="form-check-label fw-bold small" for="prob_{{ $prob->id }}">
                                        {{ $prob->name }}
                                        <span class="badge bg-secondary ms-1">{{ $prob->problem_type }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- SEO TAB -->
        <div class="tab-pane fade" id="seo" role="tabpanel">
            <div class="card card-custom">
                <h5 class="fw-bold mb-3">Search Engine Optimization</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold small">SEO Title</label>
                    <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}" placeholder="Fallback: Plant Name Care Guide | Plantaric">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
