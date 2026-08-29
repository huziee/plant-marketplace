@props(['name' => 'content_slot', 'class' => 'my-4'])

@if(auth()->check() && auth()->user()->isAdmin())
    <div class="ad-slot-placeholder text-center p-3 my-4 bg-light border border-dashed rounded-3 text-muted small" style="border:2px dashed #ccc">
        <i class="fa-solid fa-rectangle-ad me-1"></i> AdSense Slot Placeholder [<strong>{{ $name }}</strong>] (Visible to Admin only)
    </div>
@endif
