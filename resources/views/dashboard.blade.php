<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ auth()->user()->hasRole('admin') ? '🛠️ Dashboard Admin' : '👤 Dashboard Nasabah' }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @if(auth()->user()->hasRole('admin'))
            {{-- ========== ADMIN ========== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white border rounded p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold">{{ \App\Models\User::role('nasabah')->count() }}</p>
                    <p class="text-sm text-gray-600">Nasabah</p>
                </div>
                <div class="bg-white border rounded p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold">{{ \App\Models\Setoran::count() }}</p>
                    <p class="text-sm text-gray-600">Setoran</p>
                </div>
                <div class="bg-white border rounded p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold">{{ \App\Models\Withdrawal::where('status', 'pending')->count() }}</p>
                    <p class="text-sm text-gray-600">Menunggu</p>
                </div>
                <div class="bg-white border rounded p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold">{{ \App\Models\Reward::where('stok', '>', 0)->count() }}</p>
                    <p class="text-sm text-gray-600">Reward</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="/setoran/create" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">➕</div>
                    <div class="font-semibold text-sm">Input Setoran</div>
                </a>
                <a href="/admin/setoran" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">📋</div>
                    <div class="font-semibold text-sm">Semua Setoran</div>
                </a>
                <a href="/admin/withdrawal" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">💰</div>
                    <div class="font-semibold text-sm">Verifikasi Penarikan</div>
                </a>
                <a href="/admin/redemption" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">🎁</div>
                    <div class="font-semibold text-sm">Penukaran Reward</div>
                </a>
                <a href="/reward" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">🏪</div>
                    <div class="font-semibold text-sm">Kelola Reward</div>
                </a>
                <a href="/jenis-sampah" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">♻️</div>
                    <div class="font-semibold text-sm">Jenis Sampah</div>
                </a>
            </div>

        @else
            {{-- ========== NASABAH ========== --}}
            <div class="bg-gradient-to-br from-green-400 to-green-600 text-white rounded-lg p-6 shadow mb-6">
                <p class="text-sm opacity-80">Saldo Anda</p>
                <p class="text-3xl font-bold">Rp {{ number_format(auth()->user()->balance) }}</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="/setoran" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">📋</div>
                    <div class="font-semibold text-sm">Riwayat Setoran</div>
                </a>
                <a href="/withdrawal/create" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">💸</div>
                    <div class="font-semibold text-sm">Tarik Saldo</div>
                </a>
                <a href="/withdrawal" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">📜</div>
                    <div class="font-semibold text-sm">Riwayat Penarikan</div>
                </a>
                <a href="/redemption/catalog" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">🎁</div>
                    <div class="font-semibold text-sm">Tukar Reward</div>
                </a>
                <a href="/redemption" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">📦</div>
                    <div class="font-semibold text-sm">Riwayat Penukaran</div>
                </a>
                <a href="/profile" class="bg-white border p-4 rounded shadow-sm hover:shadow-md text-center">
                    <div class="text-2xl mb-1">⚙️</div>
                    <div class="font-semibold text-sm">Profil</div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>