<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg md:text-xl font-semibold text-gray-900">📊 Laporan Bisnis</h2>
                <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($dari)->format('d M Y') }} — {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.laporan.export', ['dari' => $dari, 'sampai' => $sampai]) }}">
                    <x-button size="sm" color="finance" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Setoran
                    </x-button>
                </a>
                <a href="{{ route('admin.laporan.export-withdrawals', ['dari' => $dari, 'sampai' => $sampai]) }}">
                    <x-button size="sm" color="warning" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Penarikan
                    </x-button>
                </a>
                <a href="{{ route('admin.laporan.export-redemptions', ['dari' => $dari, 'sampai' => $sampai]) }}">
                    <x-button size="sm" color="reward" type="button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Reward
                    </x-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4 max-w-6xl mx-auto">
        {{-- Filter Bar --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="text-xs font-medium text-gray-500 block mb-1">Periode</label>
                    <div class="flex items-center gap-2">
                        <input type="date" name="dari" value="{{ $dari }}" class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-eco focus:border-eco">
                        <span class="text-gray-400 text-sm">s/d</span>
                        <input type="date" name="sampai" value="{{ $sampai }}" class="text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-eco focus:border-eco">
                    </div>
                </div>
                <x-button type="submit" size="sm">Filter</x-button>
                @if(request()->anyFilled(['dari', 'sampai']))
                    <a href="{{ route('admin.laporan') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
                @endif
            </form>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <x-card-stat :value="$totalNasabah" label="Total Nasabah" color="eco"
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' />
            <x-card-stat :value="$totalSetoran" label="Total Setoran" color="finance"
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>' />
            <x-card-stat :value="number_format($totalBerat, 2) . ' kg'" label="Sampah Terkumpul" color="warning"
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>' />
            <x-card-stat :value="'Rp ' . number_format($totalSaldoDikeluarkan)" label="Saldo Dikeluarkan" color="reward"
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
        </div>

        {{-- Dua Kolom: Ringkasan + Reward --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Ringkasan per Jenis --}}
            <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">📦 Ringkasan per Jenis Sampah</h3>
                </div>
                <x-table 
                    :headers="[
                        ['label' => 'Jenis Sampah'],
                        ['label' => 'Berat', 'align' => 'text-right'],
                        ['label' => 'Saldo', 'align' => 'text-right'],
                    ]"
                    :data="collect($ringkasanJenis)"
                    emptyTitle="Belum ada data setoran"
                >
                    @foreach($ringkasanJenis as $j)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 font-medium text-gray-900">{{ $j->nama }}</td>
                        <td class="p-3 text-right text-gray-600">{{ $j->setorans_sum_berat_kg ?? 0 }} kg</td>
                        <td class="p-3 text-right text-eco font-medium">Rp {{ number_format($j->setorans_sum_total_saldo ?? 0) }}</td>
                    </tr>
                    @endforeach
                </x-table>
            </div>

            {{-- Reward Populer --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">🏆 Reward Terpopuler</h3>
                @if($rewardPopuler->count())
                    <div class="space-y-3">
                        @foreach($rewardPopuler as $i => $r)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                {{ $i === 0 ? 'bg-reward-50 text-reward' : '' }}
                                {{ $i === 1 ? 'bg-gray-100 text-gray-500' : '' }}
                                {{ $i === 2 ? 'bg-gray-100 text-gray-400' : '' }}
                                {{ $i > 2 ? 'bg-gray-50 text-gray-400' : '' }}">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $r->nama }}</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $r->redemptions_count }}x</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-gray-400 text-center py-6">Belum ada data</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>