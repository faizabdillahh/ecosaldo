<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">📊 Laporan Bisnis</h2>
    </x-slot>

    <div class="py-6 px-4">

        {{-- Filter --}}
        <div class="bg-white border rounded shadow-sm p-4 mb-4">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="text-sm block">Dari</label>
                    <input type="date" name="dari" value="{{ $dari }}" class="border rounded p-2">
                </div>
                <div>
                    <label class="text-sm block">Sampai</label>
                    <input type="date" name="sampai" value="{{ $sampai }}" class="border rounded p-2">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">🔍 Filter</button>
                <a href="{{ route('admin.laporan.export', ['dari' => $dari, 'sampai' => $sampai]) }}"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    📥 Export Setoran
                </a>
                <a href="{{ route('admin.laporan.export-withdrawals', ['dari' => $dari, 'sampai' => $sampai]) }}"
                    class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    📥 Export Penarikan
                </a>
                <a href="{{ route('admin.laporan.export-redemptions', ['dari' => $dari, 'sampai' => $sampai]) }}"
                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    📥 Export Reward
                </a>
            </form>
        </div>
        {{-- Card Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border rounded p-4 shadow-sm">
                <p class="text-2xl font-bold">{{ $totalNasabah }}</p>
                <p class="text-sm text-gray-600">Nasabah</p>
            </div>
            <div class="bg-white border rounded p-4 shadow-sm">
                <p class="text-2xl font-bold">{{ $totalSetoran }}</p>
                <p class="text-sm text-gray-600">Total Setoran</p>
            </div>
            <div class="bg-white border rounded p-4 shadow-sm">
                <p class="text-2xl font-bold">{{ number_format($totalBerat, 2) }} kg</p>
                <p class="text-sm text-gray-600">Total Sampah</p>
            </div>
            <div class="bg-white border rounded p-4 shadow-sm">
                <p class="text-2xl font-bold">Rp {{ number_format($totalSaldoDikeluarkan) }}</p>
                <p class="text-sm text-gray-600">Saldo Dikeluarkan</p>
            </div>
        </div>

        {{-- Ringkasan per Jenis --}}
        <div class="bg-white border rounded shadow-sm p-4 mb-6">
            <h3 class="font-semibold mb-3">📦 Ringkasan per Jenis Sampah</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-2 text-left">Jenis</th>
                            <th class="p-2 text-right">Total Berat</th>
                            <th class="p-2 text-right">Total Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ringkasanJenis as $j)
                        <tr class="border-t">
                            <td class="p-2">{{ $j->nama }}</td>
                            <td class="p-2 text-right">{{ $j->setorans_sum_berat_kg ?? 0 }} kg</td>
                            <td class="p-2 text-right">Rp {{ number_format($j->setorans_sum_total_saldo ?? 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Reward Populer --}}
        <div class="bg-white border rounded shadow-sm p-4">
            <h3 class="font-semibold mb-3">🏆 Reward Terpopuler</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-2 text-left">Reward</th>
                            <th class="p-2 text-right">Jumlah Ditukar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rewardPopuler as $r)
                        <tr class="border-t">
                            <td class="p-2">{{ $r->nama }}</td>
                            <td class="p-2 text-right">{{ $r->redemptions_count }} kali</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>