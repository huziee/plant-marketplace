@extends('layouts.admin')

@section('title', 'Website Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-family:'Playfair Display',serif;font-weight:700;margin:0">Website Settings</h2>
        <p class="text-muted mb-0" style="font-size:14px">Manage global platform settings, SEO defaults, social links, and appearance.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div class="card-custom p-0 overflow-hidden">
        <ul class="nav nav-tabs px-4 pt-3 border-bottom-0" id="settingsTab" role="tablist" style="background:#f8faf9">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab"><i class="fa-solid fa-sliders me-1"></i> General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab"><i class="fa-regular fa-address-book me-1"></i> Contact</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab"><i class="fa-solid fa-share-nodes me-1"></i> Social Media</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab"><i class="fa-solid fa-globe me-1"></i> SEO Defaults</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance" type="button" role="tab"><i class="fa-solid fa-palette me-1"></i> Appearance</button>
            </li>
        </ul>

        <div class="tab-content p-4" id="settingsTabContent">
            <!-- General Tab -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Site Name</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Plantaric') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline'] ?? 'Agriculture, Plants & Garden Care') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Default Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $settings['currency'] ?? 'PKR') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Timezone</label>
                        <input type="text" name="timezone" value="{{ old('timezone', $settings['timezone'] ?? 'Asia/Karachi') }}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Contact Tab -->
            <div class="tab-pane fade" id="contact" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'support@plantaric.com') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+92 300 1234567') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">WhatsApp Number</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '+92 300 1234567') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Address</label>
                        <input type="text" name="address" value="{{ old('address', $settings['address'] ?? 'Lahore, Pakistan') }}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Social Tab -->
            <div class="tab-pane fade" id="social" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Facebook URL</label>
                        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="form-control" placeholder="https://facebook.com/plantaric">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Instagram URL</label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="form-control" placeholder="https://instagram.com/plantaric">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">YouTube URL</label>
                        <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Pinterest URL</label>
                        <input type="url" name="pinterest_url" value="{{ old('pinterest_url', $settings['pinterest_url'] ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">TikTok URL</label>
                        <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">X / Twitter URL</label>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- SEO Tab -->
            <div class="tab-pane fade" id="seo" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Default SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title', $settings['seo_title'] ?? 'Plantaric — Agriculture, Plants & Botanical Care') }}" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold small">Default Meta Description</label>
                        <textarea name="seo_description" rows="3" class="form-control" required>{{ old('seo_description', $settings['seo_description'] ?? 'Discover plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert growing advice.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Appearance Tab -->
            <div class="tab-pane fade" id="appearance" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Primary Green Color</label>
                        <input type="color" name="primary_color" value="{{ old('primary_color', $settings['primary_color'] ?? '#123522') }}" class="form-control form-control-color w-100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Dark Green Color</label>
                        <input type="color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#0C2519') }}" class="form-control form-control-color w-100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Accent Green Color</label>
                        <input type="color" name="accent_color" value="{{ old('accent_color', $settings['accent_color'] ?? '#D7EF69') }}" class="form-control form-control-color w-100">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-light p-3 px-4 border-top text-end">
            <button type="submit" class="btn btn-success fw-bold px-4"><i class="fa-solid fa-save me-1"></i> Save All Settings</button>
        </div>
    </div>
</form>
@endsection
