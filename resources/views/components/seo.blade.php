@props(['title' => null, 'description' => null, 'index' => true, 'image' => null])

@php
    $settings = $settings ?? null;
    $pageTitle = $title ?: ($settings?->text('seo_title') ?: 'Ivanotechs');
    $pageDescription = $description ?: ($settings?->text('seo_description') ?: '');
    $keywords = $settings?->text('seo_keywords') ?: 'Ivanotechs, ivanotechs';
    $imageUrl = $image ?: $settings?->portraitUrl() ?: $settings?->logoUrl();
    $canonical = url()->current();
    $path = request()->path();
    $segments = $path === '/' ? [] : explode('/', $path);
@endphp

<meta name="description" content="{{ $pageDescription }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $settings->full_name ?? 'Yannick Ivan Djoukeng Nougning' }}">
<meta name="robots" content="{{ $index ? 'index, follow' : 'noindex, nofollow' }}">
<link rel="canonical" href="{{ $canonical }}">
@if ($settings?->logoUrl())
    <link rel="icon" href="{{ $settings->logoUrl() }}">
@endif

@if ($index && isset($segments[0]) && in_array($segments[0], ['en', 'de', 'fr'], true))
    @foreach (['en', 'de', 'fr'] as $code)
        @php $alternate = $segments; $alternate[0] = $code; @endphp
        <link rel="alternate" hreflang="{{ $code }}" href="{{ url(implode('/', $alternate)) }}">
    @endforeach
    @php $default = $segments; $default[0] = 'en'; @endphp
    <link rel="alternate" hreflang="x-default" href="{{ url(implode('/', $default)) }}">
@endif

<meta property="og:site_name" content="{{ $settings->site_name ?? 'Ivanotechs' }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@if ($imageUrl)
    <meta property="og:image" content="{{ $imageUrl }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
@if ($settings?->handle)
    <meta name="twitter:site" content="{{ '@'.$settings->handle }}">
@endif

@if ($index && $settings)
    <script type="application/ld+json">
        {!! json_encode([
            '@@context' => 'https://schema.org',
            '@@type' => 'Person',
            'name' => $settings->full_name,
            'alternateName' => [$settings->site_name, $settings->handle, 'Ivan Djoukeng'],
            'jobTitle' => $settings->text('role_label'),
            'email' => $settings->public_email,
            'telephone' => $settings->phone,
            'url' => url('/'.app()->getLocale()),
            'image' => $settings->portraitUrl(),
            'address' => [
                '@@type' => 'PostalAddress',
                'streetAddress' => $settings->address,
                'addressLocality' => $settings->city,
                'addressCountry' => $settings->country,
            ],
            'sameAs' => array_values(array_filter([
                $settings->github_url,
                $settings->linkedin_url,
                $settings->xing_url,
                $settings->x_url,
                $settings->website_url,
            ])),
            'knowsLanguage' => ['en', 'fr', 'de'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endif
