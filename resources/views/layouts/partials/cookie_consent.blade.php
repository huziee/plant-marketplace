{{--
    Google-certified Consent Management Platform (CMP) Hook
    Insert your Google AdSense / Cookie Consent Banner script below (e.g. Funding Choices, Cookiebot, OneTrust).
--}}
@if(setting('google_cmp_script'))
    {!! setting('google_cmp_script') !!}
@endif
