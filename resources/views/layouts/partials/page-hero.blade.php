<div class="bg-white border-bottom py-4 mb-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0 small fw-bold">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}" class="text-success text-decoration-none"><i class="fa-solid fa-house me-1"></i> Home</a></li>
                @if(isset($breadcrumbs))
                    @foreach($breadcrumbs as $name => $url)
                        <li class="breadcrumb-item"><a href="{{ $url }}" class="text-success text-decoration-none">{{ $name }}</a></li>
                    @endforeach
                @endif
                <li class="breadcrumb-item active text-muted" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="h2 font-weight-bold text-dark mb-1" style="font-family:'Playfair Display',serif">{{ $title }}</h1>
                @if(isset($subtitle) && $subtitle)
                    <p class="text-muted small mb-0">{{ $subtitle }}</p>
                @endif
            </div>
            @if(isset($icon))
                <div class="rounded-circle bg-success-subtle text-success p-3 d-grid place-items-center" style="width:52px;height:52px">
                    <i class="{{ $icon }} fa-lg"></i>
                </div>
            @endif
        </div>
    </div>
</div>
