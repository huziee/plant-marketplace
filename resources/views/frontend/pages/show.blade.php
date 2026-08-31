@extends('layouts.app')

@section('title', $page->meta_title ?: "{$page->title} — Plantaric")
@section('meta_description', $page->meta_description ?: "Read the official {$page->title} policy on Plantaric.")

@section('content')
    @include('layouts.partials.page-hero', [
        'title' => $page->title,
        'subtitle' => 'Official policy documentation and operational guidelines for Plantaric.',
        'icon' => 'fa-solid fa-shield-halved'
    ])

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="bg-white p-4 p-md-5 border rounded-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2" style="font-size:12px;text-transform:uppercase">
                            <i class="fa-solid fa-file-contract me-1"></i> Policy Document
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> Last Updated: {{ $page->updated_at->format('F d, Y') }}
                        </span>
                    </div>

                    <div class="page-content line-height-lg" style="font-size:15px;color:#2c3e35">
                        {!! $page->content !!}
                    </div>

                    <hr class="my-5">

                    <div class="p-4 bg-light rounded-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="h6 font-weight-bold mb-1">Have Questions About This Policy?</h5>
                            <p class="small text-muted mb-0">Our legal and customer support team is available to assist with inquiries.</p>
                        </div>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-sm btn-outline-success fw-bold" style="border-radius:10px">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
