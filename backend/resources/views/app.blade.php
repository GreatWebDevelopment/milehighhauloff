<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $seo = $page['props']['seo'] ?? [];
        $site = config('site');
        $title = $seo['title'] ?? 'Mile High Haul-Off | Veteran-Owned Junk Removal in Denver, CO';
        $description = $seo['description'] ?? 'Veteran-owned junk removal and hauling services for the Denver metro area. Fast, reliable, eco-friendly.';
        $image = isset($seo['image']) && $seo['image'] ? url($seo['image']) : asset('images/og-default.jpg');
        $canonical = url()->current();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    @unless (app()->environment('production'))
    <meta name="robots" content="noindex, nofollow">
    @endunless
    <link rel="canonical" href="{{ $canonical }}" />
    <meta property="og:site_name" content="{{ $site['name'] }}" />
    <meta property="og:type" content="{{ ($seo['schema'] ?? null) === 'article' ? 'article' : 'website' }}" />
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:image" content="{{ $image }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $title }}" />
    <meta name="twitter:description" content="{{ $description }}" />
    <meta name="twitter:image" content="{{ $image }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="shortcut icon" href="/favicon.ico">

    {{-- LocalBusiness schema on every page --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "LocalBusiness",
        "@id": "{{ url('/') }}/#business",
        "name": "{{ $site['name'] }}",
        "description": "Veteran-owned junk removal and hauling company serving the Denver metro area.",
        "url": "{{ url('/') }}",
        "telephone": "{{ $site['phone'] }}",
        "email": "{{ $site['email'] }}",
        "image": "{{ $image }}",
        "priceRange": "$$",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $site['address']['street'] }}",
            "addressLocality": "{{ $site['address']['locality'] }}",
            "addressRegion": "{{ $site['address']['region'] }}",
            "postalCode": "{{ $site['address']['postal_code'] }}",
            "addressCountry": "US"
        },
        "openingHoursSpecification": [
            { "@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"], "opens": "08:00", "closes": "17:00" },
            { "@type": "OpeningHoursSpecification", "dayOfWeek": "Saturday", "opens": "10:00", "closes": "15:00" }
        ],
        "areaServed": [
            @foreach ($site['service_areas'] as $i => $area)
            { "@type": "City", "name": "{{ $area }}" }@if (! $loop->last),@endif
            @endforeach
        ]
    }
    </script>

    @if (($seo['schema'] ?? null) === 'article')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": {!! json_encode($title) !!},
        "description": {!! json_encode($description) !!},
        "image": "{{ $image }}",
        "url": "{{ $canonical }}",
        @if (! empty($seo['published']))"datePublished": "{{ $seo['published'] }}",@endif
        @if (! empty($seo['modified']))"dateModified": "{{ $seo['modified'] }}",@endif
        "author": { "@type": "Organization", "name": "{{ $site['name'] }}" },
        "publisher": { "@type": "Organization", "name": "{{ $site['name'] }}" }
    }
    </script>
    @endif

    @if (($seo['schema'] ?? null) === 'service')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "Service",
        "name": {!! json_encode(str_replace(' | Mile High Haul-Off', '', $title)) !!},
        "description": {!! json_encode($description) !!},
        "url": "{{ $canonical }}",
        "provider": { "@id": "{{ url('/') }}/#business" },
        "areaServed": { "@type": "City", "name": "Denver" }
    }
    </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead

    {{-- Google tag (carried over from old site's Site Kit container); production only --}}
    @if ($site['gtag_id'] && app()->environment('production'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $site['gtag_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $site['gtag_id'] }}');
    </script>
    @endif
</head>
<body class="antialiased">
    @inertia
</body>
</html>
