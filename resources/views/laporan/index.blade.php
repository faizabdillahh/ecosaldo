<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">📊 Laporan Bisnis</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        {{-- Filter --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="text-xs text-gray-500 block mb-1">Dari</label>
                    <input type="date" name="dari" value="{{ $dari }}" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="text-xs text-gray-500 block mb-1">Sampai</label>
                    <input type="date" name="sampai" value="{{ $sampai }}" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                </div>
                <x-button type="submit" size="sm">🔍 Filter</x-button>
                <a href="{{ route('admin.laporan.export', ['dari' => $dari, 'sampai' => $sampai]) }}">
                    <x-button size="sm" color="finance" type="button">📥 Setoran</x-button>
                </a>
                <a href="{{ route('admin.laporan.export-withdrawals', ['dari' => $dari, 'sampai' => $sampai]) }}">
                    <x-button size="sm" color="warning" type="button">📥 Penarikan</x-button>
                </a>
                <a href="{{ route('admin.laporan.export-redemptions', ['dari' => $dari, 'sampai' => $sampai]) }}">
                    <x-button size="sm" color="reward" type="button">📥 Reward</x-button>
                </a>
            </form>
        </div>

        {{-- Card Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <x-card-stat :value="$totalNasabah" label="Nasabah" color="eco" />
            <x-card-stat :value="$totalSetoran" label="Total Setoran" color="finance" />
            <x-card-stat :value="number_format($totalBerat, 2) . ' kg'" label="Total Sampah" color="warning" />
            <x-card-stat :value="'Rp ' . number_format($totalSaldoDikeluarkan)" label="Saldo Dikeluarkan" color="reward" />
        </div>

        {{-- Ringkasan per Jenis --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">📦 Ringkasan per Jenis Sampah</h3>
            <x-table 
                :headers="[
                    ['label' => 'Jenis'],
                    ['label' => 'Total Berat', 'align' => 'text-right'],
                    ['label' => 'Total Saldo', 'align' => 'text-right'],
                ]"
                :data="collect($ringkasanJenis)"
                emptyTitle="Belum ada data"
            >
                @foreach($ringkasanJenis as $j)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3">{{ $j->nama }}</td>
                    <td class="p-3 text-right">{{ $j->setorans_sum_berat_kg ?? 0 }} kg</td>
                    <td class="p-3 text-right">Rp {{ number_format($j->setorans_sum_total_saldo ?? 0) }}</td>
                </tr>
                @endforeach
            </x-table>
        </div>

        {{-- Reward Populer --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">🏆 Reward Terpopuler</h3>
            @if($rewardPopuler->count())
                <div class="space-y-2">
                    @foreach($rewardPopuler as $r)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">{{ $r->nama }}</span>
                        <span class="font-medium text-gray-900">{{ $r->redemptions_count }}x</span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-gray-400">Belum ada data</p>
            @endif
        </div>
    </div>
</x-app-layout>