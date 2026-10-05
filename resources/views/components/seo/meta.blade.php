@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'robots' => null,
    'image' => null,
    'type' => 'website',
])

@inject('seoService', 'App\Services\SeoService')

@php
    $finalTitle = $seoService->title($title);
    $finalDescription = $seoService->description($description);
    $finalCanonical = $seoService->canonical($canonical);
    $finalRobots = $robots ?: $seoService->robots();
    
    $og = $seoService->openGraph([
        'title' => $finalTitle,
        'description' => $finalDescription,
        'url' => $finalCanonical,
        'image' => $image,
        'type' => $type,
    ]);

    $twitter = $seoService->twitterCard([
        'title' => $finalTitle,
        'description' => $finalDescription,
        'image' => $og['image'],
    ]);

    $googleVerification = config('lunara.google_site_verification');
@endphp

<title>{{ $finalTitle }}</title>
<meta name="description" content="{{ $finalDescription }}">
<link rel="canonical" href="{{ $finalCanonical }}">
<meta name="robots" content="{{ $finalRobots }}">

{{-- Favicon & Brand Iconography --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

{{-- Google Search Console Verification (18.74) --}}
@if($googleVerification)
<meta name="google-site-verification" content="{{ $googleVerification }}">
@endif

{{-- OpenGraph Tags (18.31 - 18.32) --}}
<meta property="og:title" content="{{ $og['title'] }}">
<meta property="og:description" content="{{ $og['description'] }}">
<meta property="og:url" content="{{ $og['url'] }}">
<meta property="og:image" content="{{ $og['image'] }}">
<meta property="og:type" content="{{ $og['type'] }}">
<meta property="og:site_name" content="{{ $og['site_name'] }}">
<meta property="og:locale" content="vi_VN">

{{-- Twitter/X Cards (18.33) --}}
<meta name="twitter:card" content="{{ $twitter['card'] }}">
<meta name="twitter:title" content="{{ $twitter['title'] }}">
<meta name="twitter:description" content="{{ $twitter['description'] }}">
<meta name="twitter:image" content="{{ $twitter['image'] }}">
