{{-- SEO Meta Tags --}}
<meta name="description" content="{{ $seoData['meta_description'] ?? 'Shop quality products at unbeatable prices. Electronics, clothing, books, home decor and more with free shipping.' }}">
<meta name="keywords" content="{{ $seoData['meta_keywords'] ?? 'ecommerce, online shopping, electronics, clothing, books, home decor, sports equipment' }}">
<meta name="robots" content="{{ $seoData['robots'] ?? 'index,follow' }}">
<meta name="author" content="ECommerce Store">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $seoData['canonical_url'] ?? url()->current() }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $seoData['meta_title'] ?? 'ECommerce Store - Quality Products at Best Prices' }}">
<meta property="og:description" content="{{ $seoData['meta_description'] ?? 'Shop quality products at unbeatable prices with fast shipping.' }}">
<meta property="og:type" content="{{ $seoData['og_type'] ?? 'website' }}">
<meta property="og:url" content="{{ $seoData['canonical_url'] ?? url()->current() }}">
<meta property="og:site_name" content="ECommerce Store">
@if(isset($seoData['og_image']))
<meta property="og:image" content="{{ $seoData['og_image'] }}">
<meta property="og:image:alt" content="{{ $seoData['meta_title'] ?? 'ECommerce Store' }}">
@else
<meta property="og:image" content="{{ asset('images/og-default.jpg') }}">
@endif

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData['meta_title'] ?? 'ECommerce Store - Quality Products at Best Prices' }}">
<meta name="twitter:description" content="{{ $seoData['meta_description'] ?? 'Shop quality products at unbeatable prices with fast shipping.' }}">
@if(isset($seoData['og_image']))
<meta name="twitter:image" content="{{ $seoData['og_image'] }}">
@endif

{{-- Additional Meta Tags --}}
<meta name="format-detection" content="telephone=no">
<meta name="theme-color" content="#667eea">

{{-- Favicon --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
