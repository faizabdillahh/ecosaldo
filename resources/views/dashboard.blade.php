<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">
            {{ auth()->user()->hasRole('admin') ? 'Dashboard Admin' : 'Dashboard Nasabah' }}
        </h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        @if(auth()->user()->hasRole('admin'))
            {{-- ========== ADMIN ========== --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                <div class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm">
                    <svg class="w-6 h-6 mx-auto mb-1 text-eco" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ \App\Models\User::role('nasabah')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Nasabah</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm">
                    <svg class="w-6 h-6 mx-auto mb-1 text-finance" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ \App\Models\Setoran::count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Setoran</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm">
                    <svg class="w-6 h-6 mx-auto mb-1 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xl sm:text-2xl font-bold text-warning">{{ \App\Models\Withdrawal::where('status', 'pending')->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Menunggu</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm">
                    <svg class="w-6 h-6 mx-auto mb-1 text-reward" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <p class="text-xl sm:text-2xl font-bold text-reward">{{ \App\Models\Reward::where('stok', '>', 0)->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Reward</p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <a href="/setoran/create" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-eco" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Input Setoran</div>
                </a>
                <a href="/admin/setoran" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-finance" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Semua Setoran</div>
                </a>
                <a href="/admin/withdrawal" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Verifikasi Penarikan</div>
                </a>
                <a href="/admin/redemption" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-reward" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Penukaran Reward</div>
                </a>
                <a href="/reward" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-reward" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Kelola Reward</div>
                </a>
                <a href="/jenis-sampah" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-eco" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Jenis Sampah</div>
                </a>
            </div>

        @else
            {{-- ========== NASABAH ========== --}}
            <div class="bg-finance text-white rounded-2xl p-4 sm:p-6 shadow-lg mb-6">
                <p class="text-xs sm:text-sm opacity-80">Saldo Anda</p>
                <p class="text-2xl sm:text-3xl font-bold">Rp {{ number_format(auth()->user()->balance) }}</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <a href="/setoran" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-finance" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Riwayat Setoran</div>
                </a>
                <a href="/withdrawal/create" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-eco" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Tarik Saldo</div>
                </a>
                <a href="/withdrawal" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Riwayat Penarikan</div>
                </a>
                <a href="/redemption/catalog" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-reward" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Tukar Reward</div>
                </a>
                <a href="/redemption" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-reward" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Riwayat Penukaran</div>
                </a>
                <a href="/profile" class="bg-white border border-gray-200 rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md hover:border-eco-200 transition">
                    <svg class="w-6 h-6 mx-auto mb-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div class="text-xs sm:text-sm font-semibold text-gray-900">Profil</div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>