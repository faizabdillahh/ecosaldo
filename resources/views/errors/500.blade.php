<!DOCTYPE html>
<html lang="id">
<head>
    <x-seo title="500 - Error Server | EcoSaldo" description="Terjadi kesalahan pada server. Silakan coba lagi nanti." />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center">
            <div class="text-7xl font-extrabold text-red-500 mb-4">500</div>
            <h1 class="text-xl font-bold text-gray-900 mb-2">Error Server</h1>
            <p class="text-sm text-gray-500 mb-6">Terjadi kesalahan teknis. Tim kami sedang menanganinya. Silakan coba lagi nanti.</p>
            <a href="/" class="inline-flex items-center gap-2 bg-eco text-white px-6 py-3 rounded-xl font-semibold hover:bg-eco-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>