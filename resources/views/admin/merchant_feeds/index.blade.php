@extends('layouts.admin')

@section('title', 'Merchant Feeds & Product Syndication')

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Merchant Feeds & Product Syndication</h1>
            <p class="text-muted mb-0">Manage live product feeds, external search channels, and monitor feed synchronization logs.</p>
        </div>
        <div>
            <form action="{{ route('admin.merchant-feeds.sync-google') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success fw-bold px-3 py-2 shadow-sm" style="border-radius:12px;background:var(--green-900)">
                    <i class="fa-solid fa-rotate me-1"></i> Sync Google Feed Now
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius:14px">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Bar -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card card-custom h-100 mb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Products in Feed</span>
                        <h2 class="fw-bold text-dark mb-0">{{ number_format($publishedProductsCount) }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:var(--green-50);color:var(--green-800)">
                        <i class="fa-solid fa-box-open fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card card-custom h-100 mb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Google Feed Status</span>
                        <h2 class="h4 fw-bold text-success mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> Healthy & Live
                        </h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#e8f5e9;color:#2e7d32">
                        <i class="fa-brands fa-google fs-5"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card card-custom h-100 mb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Feed Sync Logs</span>
                        <h2 class="fw-bold text-dark mb-0">{{ number_format($totalSyncsCount) }}</h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:#f3e5f5;color:#7b1fa2">
                        <i class="fa-solid fa-list-check fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Integration Cards Grid -->
    <h4 class="fw-bold text-dark mb-3">Merchant Integrations</h4>
    <div class="row g-4 mb-4">
        <!-- 1. Google Merchant Card (Active) -->
        <div class="col-12 col-lg-4">
            <div class="card card-custom h-100 mb-0 border-success" style="border-width:1.5px">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#e8f5e9;color:#2e7d32">
                            <i class="fa-brands fa-google fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">Google Merchant</h5>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1 rounded-pill" style="font-size:11px">
                        <i class="fa-solid fa-circle-check me-1"></i> Active
                    </span>
                </div>

                <p class="text-muted small mb-3">Google Merchant Center RSS 2.0 product catalog feed with live inventory and pricing sync.</p>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted mb-1">Public XML Feed URL</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control bg-light text-dark" id="googleFeedInput" value="{{ $googleFeedUrl }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyGoogleUrl()">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 small mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Items Count:</span>
                        <strong class="text-dark">{{ $publishedProductsCount }} products</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Format:</span>
                        <strong class="text-dark">XML / Google RSS 2.0</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Last Sync:</span>
                        <strong class="text-dark">{{ $lastGoogleSync ? $lastGoogleSync->created_at->diffForHumans() : 'Never' }}</strong>
                    </div>
                </div>

                <div class="mt-auto d-flex gap-2">
                    <a href="{{ $googleFeedUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary flex-grow-1" style="border-radius:10px">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Feed XML
                    </a>
                    <form action="{{ route('admin.merchant-feeds.sync-google') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success fw-bold" style="border-radius:10px;background:var(--green-900)">
                            <i class="fa-solid fa-rotate me-1"></i> Sync
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. Pinterest Card (Coming Soon) -->
        <div class="col-12 col-lg-4">
            <div class="card card-custom h-100 mb-0 opacity-75">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#fde8e8;color:#e60023">
                            <i class="fa-brands fa-pinterest fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">Pinterest Catalog</h5>
                    </div>
                    <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill" style="font-size:11px">
                        <i class="fa-solid fa-clock me-1"></i> Coming Soon
                    </span>
                </div>

                <p class="text-muted small mb-3">Automatic Rich Product Pins integration & catalog sync for Pinterest Shopping.</p>

                <div class="p-3 bg-light rounded-3 small mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Rich Pins Meta:</span>
                        <strong class="text-muted">In Development</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Pinterest Tag:</span>
                        <strong class="text-muted">Coming Soon</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status:</span>
                        <strong class="text-warning">Planned</strong>
                    </div>
                </div>

                <div class="mt-auto">
                    <button class="btn btn-sm btn-light text-muted w-100 fw-bold disabled" style="border-radius:10px">
                        <i class="fa-solid fa-lock me-1"></i> Integration Coming Soon
                    </button>
                </div>
            </div>
        </div>

        <!-- 3. OpenAI Merchant Card (Coming Soon) -->
        <div class="col-12 col-lg-4">
            <div class="card card-custom h-100 mb-0 opacity-75">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;background:#f3e8ff;color:#7e22ce">
                            <i class="fa-solid fa-robot fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">OpenAI & AI Merchant</h5>
                    </div>
                    <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill" style="font-size:11px">
                        <i class="fa-solid fa-clock me-1"></i> Coming Soon
                    </span>
                </div>

                <p class="text-muted small mb-3">LLM-structured product data feed & OpenAPI manifest for conversational AI shopping agents.</p>

                <div class="p-3 bg-light rounded-3 small mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">JSON-LD Schemas:</span>
                        <strong class="text-muted">In Development</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">GPT Crawler Access:</span>
                        <strong class="text-muted">Coming Soon</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status:</span>
                        <strong class="text-warning">Planned</strong>
                    </div>
                </div>

                <div class="mt-auto">
                    <button class="btn btn-sm btn-light text-muted w-100 fw-bold disabled" style="border-radius:10px">
                        <i class="fa-solid fa-lock me-1"></i> Integration Coming Soon
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sync Tracking Logs Table -->
    <div class="card card-custom">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-clock-rotate-left me-2 text-success"></i>Sync Track Logs</h4>
                <p class="text-muted small mb-0">Detailed audit records of automated Google Merchant feed fetches and manual syncs.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">#ID</th>
                        <th>Channel</th>
                        <th>Trigger Type</th>
                        <th>Status</th>
                        <th>Items Synced</th>
                        <th>Client / IP</th>
                        <th>Message</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td><span class="fw-bold text-muted">#{{ $log->id }}</span></td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success fw-bold text-capitalize">
                                    <i class="fa-brands fa-google me-1"></i> {{ str_replace('_', ' ', $log->channel) }}
                                </span>
                            </td>
                            <td>
                                @if($log->trigger_type === 'manual_sync')
                                    <span class="badge bg-primary-subtle text-primary border border-primary fw-bold">
                                        <i class="fa-solid fa-user me-1"></i> Manual Sync
                                    </span>
                                @else
                                    <span class="badge bg-info-subtle text-info border border-info fw-bold">
                                        <i class="fa-solid fa-bolt me-1"></i> Auto Fetch
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($log->status === 'success')
                                    <span class="badge bg-success text-white fw-bold"><i class="fa-solid fa-check me-1"></i> Success</span>
                                @else
                                    <span class="badge bg-danger text-white fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> {{ ucfirst($log->status) }}</span>
                                @endif
                            </td>
                            <td><strong class="text-dark">{{ $log->items_count }}</strong> items</td>
                            <td>
                                <span class="small font-monospace text-muted">{{ $log->ip_address ?: 'System' }}</span>
                            </td>
                            <td><span class="small text-muted">{{ $log->message }}</span></td>
                            <td><span class="small text-muted">{{ $log->created_at->format('M d, Y — H:i:s') }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-muted"></i>
                                No feed sync logs recorded yet. Click "Sync Google Feed Now" or access the XML feed to generate logs.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

@push('admin_scripts')
<script>
function copyGoogleUrl() {
    const copyText = document.getElementById("googleFeedInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Google Merchant Feed URL copied to clipboard:\n" + copyText.value);
}
</script>
@endpush
@endsection
