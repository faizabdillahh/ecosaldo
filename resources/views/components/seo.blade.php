@props([
    'title' => 'EcoSaldo - Sampahmu, Saldomu',
    'description' => 'Platform bank sampah digital pertama. Setor sampah, dapat saldo, tarik tunai atau tukar reward.',
    'image' => null,
    'url' => null,
    'robots' => 'index, follow',
    'canonical' => null,
    'author' => 'EcoSaldo',
    'locale' => 'id_ID',
    'siteName' => 'EcoSaldo',
])

{{-- Primary Meta --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="author" content="{{ $author }}">
<meta name="robots" content="{{ $robots }}">

{{-- Open Graph / Facebook --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="{{ $locale }}">
@if($url)<meta property="og:url" content="{{ $url }}">@endif
@if($image)<meta property="og:image" content="{{ $image }}">@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)<meta name="twitter:image" content="{{ $image }}">@endif

{{-- Canonical URL --}}
@if($canonical || $url)
    <link rel="canonical" href="{{ $canonical ?? $url }}">
@endif

{{-- Favicon --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "EcoSaldo",
    "url": "{{ url('/') }}",
    "description": "Platform bank sampah digital pertama. Setor sampah, dapat saldo, tarik tunai atau tukar reward.",
    "logo": "{{ asset('favicon.ico') }}",
    "sameAs": []
}
</script>