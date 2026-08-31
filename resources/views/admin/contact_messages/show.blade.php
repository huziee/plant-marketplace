@extends('layouts.admin')

@section('title', 'View Contact Message - Plantaric Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-envelope-open text-primary me-2"></i>Contact Message Details</h1>
        <p class="text-muted small mb-0">Received on {{ $message->created_at->format('F d, Y \a\t H:i') }}</p>
    </div>
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary" style="border-radius:12px">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Messages
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <h4 class="h5 font-weight-bold mb-0" style="font-family:'Playfair Display',serif">{{ $message->subject }}</h4>
                <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2">
                    IP: {{ $message->ip_address ?: 'Unknown' }}
                </span>
            </div>

            <div class="p-3 bg-light rounded-3 mb-4">
                <p class="mb-0 text-dark line-height-lg" style="white-space:pre-wrap;font-size:15px">{{ $message->message }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="mailto:{{ $message->email }}?subject=RE: {{ urlencode($message->subject) }}" class="btn btn-success fw-bold" style="border-radius:12px;background:var(--green-900)">
                    <i class="fa-solid fa-reply me-1"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Sender Information</h5>
            <div class="mb-3">
                <label class="text-muted small d-block">Full Name</label>
                <div class="fw-bold text-dark">{{ $message->name }}</div>
            </div>
            <div class="mb-3">
                <label class="text-muted small d-block">Email Address</label>
                <div class="fw-bold"><a href="mailto:{{ $message->email }}" class="text-success text-decoration-none">{{ $message->email }}</a></div>
            </div>
            <div class="mb-3">
                <label class="text-muted small d-block">Date Received</label>
                <div class="text-dark">{{ $message->created_at->format('M d, Y H:i:s') }}</div>
            </div>
        </div>

        <div class="card-custom">
            <h5 class="fw-bold mb-3" style="font-family:'Playfair Display',serif">Message Status</h5>
            <form action="{{ route('admin.contact-messages.update-status', $message) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <select name="status" class="form-select mb-3">
                        <option value="new" {{ $message->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>Replied</option>
                        <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary w-100 fw-bold" style="border-radius:12px">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
