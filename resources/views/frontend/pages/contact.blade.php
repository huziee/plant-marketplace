@extends('layouts.app')

@section('title', 'Contact Us — Plantaric Support')
@section('meta_description', 'Get in touch with the Plantaric team for order inquiries, plant care questions, partnership opportunities, or feedback.')

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => 'Contact Us',
        'subtitle' => 'Have questions about your order, plant health, or partnerships? We are here to help.',
        'icon' => 'fa-solid fa-headset'
    ])

    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius:14px;background:#e8f3ea;color:#1c4d31" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-5">
            <!-- Left Column: Support Info & Office Details -->
            <div class="col-lg-5">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="eyebrow mb-3"><i class="fa-solid fa-envelope-open text-success"></i> GET IN TOUCH</span>
                        <h2 class="h3 font-weight-bold mb-3" style="font-family:'Playfair Display',serif">We'd love to hear from you.</h2>
                        <p class="text-muted mb-4">Whether you need help choosing the right low-light plant, tracking your marketplace order, or discussing editorial partnerships, reach out to our team.</p>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-circle bg-success-subtle text-success p-3 d-grid place-items-center flex-shrink-0" style="width:44px;height:44px">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="h6 font-weight-bold mb-1">Email Support</h3>
                                <p class="text-muted small mb-0">{{ setting('contact_email', 'support@plantaric.com') }}</p>
                                <small class="text-muted">Typically replies within 24 hours</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-circle bg-success-subtle text-success p-3 d-grid place-items-center flex-shrink-0" style="width:44px;height:44px">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="h6 font-weight-bold mb-1">Customer Helpline</h3>
                                <p class="text-muted small mb-0">{{ setting('contact_phone', '+93 330 4789990') }}</p>
                                <small class="text-muted">Mon–Fri: 9:00 AM – 6:00 PM EST</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-circle bg-success-subtle text-success p-3 d-grid place-items-center flex-shrink-0" style="width:44px;height:44px">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="h6 font-weight-bold mb-1">Business Hours</h3>
                                <p class="text-muted small mb-0">Monday – Friday: 9:00 AM – 6:00 PM</p>
                                <p class="text-muted small mb-0">Saturday: 10:00 AM – 4:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3">
                        <small class="text-muted d-block"><i class="fa-solid fa-shield-halved text-success me-1"></i> <strong>Spam Protected:</strong> Your information is kept confidential under our Privacy Policy.</small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact Form -->
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <h3 class="h4 font-weight-bold mb-4" style="font-family:'Playfair Display',serif">Send Us a Message</h3>

                    <form action="{{ route('frontend.contact.submit') }}" method="POST" id="contactForm">
                        @csrf

                        <!-- Anti-Spam Honeypot Field (Hidden from real users) -->
                        <div style="display:none !important;" aria-hidden="true">
                            <label for="website">Leave this field blank</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small">Your Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()?->name) }}" required placeholder="e.g. Sarah Jenkins">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()?->email) }}" required placeholder="e.g. sarah@example.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label font-weight-bold small">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required placeholder="e.g. Order Inquiry #PLN-2026-8491">
                                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label font-weight-bold small">Message Body <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" required placeholder="Write your message details here (minimum 10 characters)...">{{ old('message') }}</textarea>
                                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-success px-4 py-3 fw-bold w-100" style="border-radius:14px;background:var(--green-900)">
                                    <i class="fa-solid fa-paper-plane me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
