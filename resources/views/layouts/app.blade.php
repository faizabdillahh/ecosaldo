<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-seo />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    {{-- Skip Link --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 bg-eco text-white px-4 py-2 rounded-lg z-50">
        Skip ke konten utama
    </a>

    <div class="min-h-screen bg-gray-50">
        @include('layouts.navigation')

        @isset($header)
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <main id="main-content">
            {{ $slot }}
        </main>
    </div>

    <footer class="bg-gray-900 text-gray-400 text-xs text-center py-6 px-4 mt-8">
        &copy; {{ now()->year }} EcoSaldo. Sampahmu, Saldomu.
    </footer>
</body>
</html>