<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900">Verifikasi Penarikan</h2>
            @if($pending > 0)
                <span class="bg-warning-50 text-warning-800 text-xs px-3 py-1 rounded-full font-medium">
                    {{ $pending }} menunggu
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        @if(session('success'))
            <div class="bg-eco-50 text-eco-800 text-sm p-3 rounded-xl mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-700 text-sm p-3 rounded-xl mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" class="bg-white border border-gray-200 rounded-xl p-3 mb-4 flex flex-wrap gap-2 items-end">
            <x-select 
                label="Nasabah"
                name="user_id"
                :options="$nasabahs->pluck('name', 'id')->toArray()"
                :selected="request('user_id')"
                placeholder="Semua Nasabah"
            />

            <x-select 
                label="Status"
                name="status"
                :options="\App\Enums\WithdrawalStatus::options()"
                :selected="request('status')"
                placeholder="Semua Status"
            />

            <div>
                <label class="text-xs text-gray-500 block mb-1">Bulan</label>
                <input type="month" name="month" value="{{ request('month') }}" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
            </div>

            <button type="submit" class="bg-eco text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-eco-700 transition">
                Filter
            </button>
            @if(request()->anyFilled(['user_id', 'status', 'month']))
                <a href="{{ route('admin.withdrawal.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
            @endif
        </form>

        <x-table 
            :headers="[
                ['label' => 'Nasabah'],
                ['label' => 'Jumlah', 'align' => 'text-right'],
                ['label' => 'Bank'],
                ['label' => 'Rekening', 'align' => 'text-right'],
                ['label' => 'Status', 'align' => 'text-center'],
                ['label' => 'Aksi', 'align' => 'text-right'],
            ]"
            :data="$withdrawals"
            emptyTitle="Tidak ada pengajuan penarikan"
            emptyDescription="Penarikan yang diajukan nasabah akan muncul di sini"
        >
            {{-- Desktop Rows --}}
            @foreach($withdrawals as $w)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3">
                    <span class="font-medium text-gray-900">{{ $w->user->name }}</span>
                </td>
                <td class="p-3 text-right font-medium">Rp {{ number_format($w->jumlah) }}</td>
                <td class="p-3 text-gray-600 text-sm">{{ $w->bank_tujuan }}</td>
                <td class="p-3 text-right text-gray-600 text-sm font-mono">{{ $w->norek_tujuan }}</td>
                <td class="p-3 text-center">
                    <x-badge :status="$w->status" type="withdrawal" />
                </td>
                <td class="p-3 text-right">
                    @if($w->status === \App\Enums\WithdrawalStatus::PENDING)
                        <form action="{{ route('admin.withdrawal.verify', $w) }}" method="POST">
                            @csrf
                            <button class="bg-eco text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-eco-700 transition">
                                Setujui
                            </button>
                        </form>
                    @else
                        <span class="text-xs text-gray-400">—</span>
                    @endif
                </td>
            </tr>
            @endforeach

            {{-- Mobile Cards --}}
            <x-slot:mobile>
                @foreach($withdrawals as $w)
                <div class="p-4 {{ $w->status === \App\Enums\WithdrawalStatus::PENDING ? 'bg-warning-50/30' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-900">{{ $w->user->name }}</span>
                        <x-badge :status="$w->status" type="withdrawal" />
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Rp {{ number_format($w->jumlah) }}</span>
                        <span class="text-gray-400 text-xs">{{ $w->bank_tujuan }} · {{ $w->norek_tujuan }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $w->created_at->format('d M Y, H:i') }}</p>
                    @if($w->status === \App\Enums\WithdrawalStatus::PENDING)
                        <form action="{{ route('admin.withdrawal.verify', $w) }}" method="POST" class="mt-2">
                            @csrf
                            <button class="w-full bg-eco text-white py-2 rounded-xl text-sm font-semibold">
                                Setujui
                            </button>
                        </form>
                    @endif
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>