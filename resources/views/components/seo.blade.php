@props(['seoService' => null])

@php
    $service = $seoService ?? app(\App\Services\SEO\SeoService::class);
@endphp

{!! $service->renderTags() !!}
