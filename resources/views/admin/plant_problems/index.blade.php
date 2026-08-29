@extends('layouts.admin')

@section('title', 'Plant Problems & Treatments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">Plant Doctor Problems</h2>
        <p class="text-muted small mb-0">Manage plant diseases, pests, watering symptoms, causes, and step-by-step treatment guides.</p>
    </div>
    <a href="{{ route('admin.plant-problems.create') }}" class="btn btn-success fw-bold" style="border-radius:12px;background:var(--green-900)">
        <i class="fa-solid fa-plus me-1"></i> Add Problem
    </a>
</div>

<div class="card card-custom">
    <!-- Filter bar -->
    <form method="GET" action="{{ route('admin.plant-problems.index') }}" class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search problems..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="problem_type" class="form-select" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="disease" {{ request('problem_type') === 'disease' ? 'selected' : '' }}>Disease</option>
                <option value="pest" {{ request('problem_type') === 'pest' ? 'selected' : '' }}>Pest</option>
                <option value="watering" {{ request('problem_type') === 'watering' ? 'selected' : '' }}>Watering</option>
                <option value="nutrient" {{ request('problem_type') === 'nutrient' ? 'selected' : '' }}>Nutrient</option>
                <option value="environment" {{ request('problem_type') === 'environment' ? 'selected' : '' }}>Environment</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="severity" class="form-select" onchange="this.form.submit()">
                <option value="">All Severities</option>
                <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('severity') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('severity') === 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.plant-problems.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Problem Name</th>
                    <th>Type</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($problems as $problem)
                    <tr>
                        <td>
                            <strong class="d-block">{{ $problem->name }}</strong>
                            <small class="text-muted">{{ Str::limit($problem->short_description, 60) }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark text-capitalize">{{ $problem->problem_type }}</span>
                        </td>
                        <td>
                            @if($problem->severity === 'high')
                                <span class="badge bg-danger">High Severity</span>
                            @elseif($problem->severity === 'medium')
                                <span class="badge bg-warning text-dark">Medium Severity</span>
                            @else
                                <span class="badge bg-info text-dark">Low Severity</span>
                            @endif
                        </td>
                        <td>
                            @if($problem->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($problem->is_featured)
                                <span class="badge bg-success-subtle text-success">Featured</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.plant-problems.edit', $problem->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.plant-problems.destroy', $problem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this problem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No plant problems found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $problems->links() }}
    </div>
</div>
@endsection
