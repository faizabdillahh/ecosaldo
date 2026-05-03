<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ auth()->user()->hasRole('admin') ? '🛠️ Dashboard Admin' : '👤 Dashboard Nasabah' }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @if(auth()->user()->hasRole('admin'))
            {{-- ========== ADMIN DASHBOARD ========== --}}
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
                    <p class="text-sm text-gray-600">Menunggu Verifikasi</p>
                </div>
                <div class="bg-white border rounded p-4 text-center shadow-sm">
                    <p class="text-2xl font-bold">{{ \App\Models\Reward::where('stok', '>', 0)->count() }}</p>
                    <p class="text-sm text-gray-600">Reward Tersedia</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="/setoran/create" class="bg-blue-50 border border-blue-200 p-6 rounded-lg hover:bg-blue-100 text-center">
                    <div class="text-3xl mb-2">➕</div>
                    <div class="font-semibold">Input Setoran</div>
                    <div class="text-sm text-gray-600">Catat setoran nasabah</div>
                </a>
                <a href="/admin/setoran" class="bg-green-50 border border-green-200 p-6 rounded-lg hover:bg-green-100 text-center">
                    <div class="text-3xl mb-2">📋</div>
                    <div class="font-semibold">Semua Setoran</div>
                    <div class="text-sm text-gray-600">Lihat riwayat setoran</div>
                </a>
                <a href="/admin/withdrawal" class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg hover:bg-yellow-100 text-center">
                    <div class="text-3xl mb-2">💰</div>
                    <div class="font-semibold">Verifikasi Penarikan</div>
                    <div class="text-sm text-gray-600">Setujui tarik saldo</div>
                </a>
                <a href="/admin/redemption" class="bg-purple-50 border border-purple-200 p-6 rounded-lg hover:bg-purple-100 text-center">
                    <div class="text-3xl mb-2">🎁</div>
                    <div class="font-semibold">Penukaran Reward</div>
                    <div class="text-sm text-gray-600">Proses penukaran</div>
                </a>
                <a href="/reward" class="bg-pink-50 border border-pink-200 p-6 rounded-lg hover:bg-pink-100 text-center">
                    <div class="text-3xl mb-2">🏪</div>
                    <div class="font-semibold">Kelola Reward</div>
                    <div class="text-sm text-gray-600">CRUD katalog reward</div>
                </a>
                <a href="/jenis-sampah" class="bg-indigo-50 border border-indigo-200 p-6 rounded-lg hover:bg-indigo-100 text-center">
                    <div class="text-3xl mb-2">♻️</div>
                    <div class="font-semibold">Jenis Sampah</div>
                    <div class="text-sm text-gray-600">Kelola harga sampah</div>
                </a>
            </div>

        @else
            {{-- ========== NASABAH DASHBOARD ========== --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gradient-to-br from-green-400 to-green-600 text-white rounded-lg p-6 shadow">
                    <p class="text-sm opacity-80">Saldo Anda</p>
                    <p class="text-3xl font-bold">Rp {{ number_format(auth()->user()->balance) }}</p>
                </div>
                <div class="bg-white border rounded p-6 shadow-sm">
                    <p class="text-sm text-gray-600">Total Setoran</p>
                    <p class="text-2xl font-bold">{{ auth()->user()->setorans()->count() }} kali</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="/setoran" class="bg-blue-50 border border-blue-200 p-6 rounded-lg hover:bg-blue-100 text-center">
                    <div class="text-3xl mb-2">📋</div>
                    <div class="font-semibold">Riwayat Setoran</div>
                    <div class="text-sm text-gray-600">Lihat setoran Anda</div>
                </a>
                <a href="/withdrawal/create" class="bg-green-50 border border-green-200 p-6 rounded-lg hover:bg-green-100 text-center">
                    <div class="text-3xl mb-2">💸</div>
                    <div class="font-semibold">Tarik Saldo</div>
                    <div class="text-sm text-gray-600">Cairkan ke rekening</div>
                </a>
                <a href="/withdrawal" class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg hover:bg-yellow-100 text-center">
                    <div class="text-3xl mb-2">📜</div>
                    <div class="font-semibold">Riwayat Penarikan</div>
                    <div class="text-sm text-gray-600">Lihat status penarikan</div>
                </a>
                <a href="/redemption/catalog" class="bg-purple-50 border border-purple-200 p-6 rounded-lg hover:bg-purple-100 text-center">
                    <div class="text-3xl mb-2">🎁</div>
                    <div class="font-semibold">Tukar Reward</div>
                    <div class="text-sm text-gray-600">Katalog reward</div>
                </a>
                <a href="/redemption" class="bg-pink-50 border border-pink-200 p-6 rounded-lg hover:bg-pink-100 text-center">
                    <div class="text-3xl mb-2">📦</div>
                    <div class="font-semibold">Riwayat Penukaran</div>
                    <div class="text-sm text-gray-600">Status reward Anda</div>
                </a>
                <a href="/profile" class="bg-gray-50 border border-gray-200 p-6 rounded-lg hover:bg-gray-100 text-center">
                    <div class="text-3xl mb-2">⚙️</div>
                    <div class="font-semibold">Profil</div>
                    <div class="text-sm text-gray-600">Atur akun & bank</div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>