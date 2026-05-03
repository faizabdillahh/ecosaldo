<!DOCTYPE html>
<html lang="id">
<head>
    <x-seo />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-eco px-4 py-3 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="/" class="flex items-center gap-1.5 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-lg font-bold">EcoSaldo</span>
            </a>
            <div class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white font-medium hover:text-eco-50 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-white font-medium hover:text-eco-50 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-eco px-4 py-2 rounded-lg font-semibold shadow hover:bg-eco-50 transition text-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="bg-gradient-to-b from-eco to-eco-800 text-white px-4 py-16 sm:py-24 md:py-28">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 text-xs sm:text-sm mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Platform Bank Sampah Digital
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight">
                Sampahmu,<br class="sm:hidden">
                <span class="text-reward-400">Saldomu</span>
            </h1>
            <p class="text-sm sm:text-base text-eco-50 mt-4 max-w-md mx-auto leading-relaxed">
                Setor sampah, dapat saldo, tarik tunai atau tukar reward. Semua tercatat rapi dan transparan.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-eco font-bold px-6 py-3.5 rounded-xl text-base shadow-lg hover:bg-eco-50 transition">
                        Mulai Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-eco font-bold px-6 py-3.5 rounded-xl text-base shadow-lg hover:bg-eco-50 transition">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white text-white font-semibold px-6 py-3.5 rounded-xl text-base hover:bg-white/10 transition">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="px-4 py-16 sm:py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Mengapa EcoSaldo?</h2>
                <p class="text-sm text-gray-500 mt-2">Ubah sampah jadi saldo dalam 3 langkah mudah</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="w-14 h-14 bg-eco-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-eco" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Setor Sampah</h3>
                    <p class="text-sm text-gray-500">Bawa sampahmu ke bank sampah, petugas catat digital. Saldo otomatis bertambah.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="w-14 h-14 bg-finance-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-finance" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Tarik Saldo</h3>
                    <p class="text-sm text-gray-500">Cairkan saldo ke rekening bank. Langsung diproses, tanpa tunggu lama.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="w-14 h-14 bg-reward-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-reward" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Tukar Reward</h3>
                    <p class="text-sm text-gray-500">Tukar saldo dengan pulsa, sembako, token listrik. Banyak pilihan hadiah.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="px-4 py-12 bg-white">
        <div class="max-w-3xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
            <x-card-stat :value="\App\Models\User::role('nasabah')->count()" label="Nasabah Aktif" color="eco" />
            <x-card-stat :value="\App\Models\Setoran::count()" label="Setoran Tercatat" color="finance" />
            <x-card-stat :value="\App\Models\Reward::where('stok', '>', 0)->count()" label="Reward Tersedia" color="reward" />
            <x-card-stat value="100%" label="Transparan" color="gray" />
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-eco-700 text-white px-4 py-14 text-center">
        <h2 class="text-xl sm:text-2xl font-bold">Siap menabung dari sampah?</h2>
        <p class="text-eco-50 text-sm mt-2 mb-6">Gabung sekarang, setor sampah pertamamu, dapatkan saldo.</p>
        @guest
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-reward text-white font-bold px-6 py-3.5 rounded-xl text-base shadow-lg hover:bg-reward-700 transition">
                Daftar Sekarang
            </a>
        @endguest
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 text-xs text-center py-6 px-4">
        &copy; 2026 EcoSaldo. Sampahmu, Saldomu.
    </footer>

</body>
</html>