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
        {{-- Flash Messages --}}
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

        {{-- Filters --}}
        <form method="GET" class="bg-white border border-gray-200 rounded-xl p-3 mb-4 flex flex-wrap gap-2 items-end">
            <div>
                <label class="text-xs text-gray-500 block mb-1">Nasabah</label>
                <select name="user_id" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                    <option value="">Semua Nasabah</option>
                    @foreach($nasabahs as $n)
                        <option value="{{ $n->id }}" {{ request('user_id') == $n->id ? 'selected' : '' }}>{{ $n->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500 block mb-1">Status</label>
                <select name="status" class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                    <option value="">Semua Status</option>
                    @foreach(\App\Enums\WithdrawalStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
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

        @if($withdrawals->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-sm">Tidak ada data</p>
            </div>
        @else
            @php $grouped = $withdrawals->groupBy('user_id'); @endphp

            @foreach($grouped as $userId => $items)
                @php $nasabah = $items->first()->user; @endphp
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 bg-eco-50 rounded-full flex items-center justify-center text-eco font-bold text-sm">
                            {{ strtoupper(substr($nasabah->name, 0, 1)) }}
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">{{ $nasabah->name }}</span>
                            <span class="text-xs text-gray-400 ml-1">{{ $items->count() }} transaksi</span>
                        </div>
                    </div>

                    {{-- Pending Items --}}
                    @php $pendingItems = $items->filter(fn($w) => $w->status === \App\Enums\WithdrawalStatus::PENDING); @endphp
                    @if($pendingItems->count())
                        <div class="text-xs font-medium text-warning-800 mb-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Menunggu Verifikasi ({{ $pendingItems->count() }})
                        </div>
                        @foreach($pendingItems as $w)
                            <div class="bg-white border border-warning-200 rounded-xl p-3 mb-2 shadow-sm sm:flex sm:items-center sm:justify-between">
                                <div class="sm:flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($w->jumlah) }}</span>
                                        <span class="bg-warning-50 text-warning-800 text-xs px-2 py-0.5 rounded-full">{{ $w->status->label() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $w->bank_tujuan }} · {{ $w->norek_tujuan }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $w->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <form action="{{ route('admin.withdrawal.verify', $w) }}" method="POST">
                                        @csrf
                                        <button class="w-full sm:w-auto bg-eco text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-eco-700 transition">
                                            Setujui
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- Verified Items --}}
                    @php $verifiedItems = $items->filter(fn($w) => $w->status !== \App\Enums\WithdrawalStatus::PENDING); @endphp
                    @if($verifiedItems->count())
                        <div class="text-xs font-medium text-gray-400 mb-2 mt-3 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Terverifikasi ({{ $verifiedItems->count() }})
                        </div>
                        @foreach($verifiedItems as $w)
                            <div class="bg-white border border-gray-100 rounded-xl p-3 mb-2 shadow-sm sm:flex sm:items-center sm:justify-between opacity-70">
                                <div class="sm:flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($w->jumlah) }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded-full
                                            {{ $w->status === \App\Enums\WithdrawalStatus::SUCCESS ? 'bg-eco-50 text-eco-800' : '' }}
                                            {{ $w->status === \App\Enums\WithdrawalStatus::PROCESSING ? 'bg-finance-50 text-finance-800' : '' }}
                                            {{ $w->status === \App\Enums\WithdrawalStatus::VERIFIED ? 'bg-finance-50 text-finance-800' : '' }}
                                            {{ $w->status === \App\Enums\WithdrawalStatus::FAILED ? 'bg-red-50 text-red-700' : '' }}
                                        ">
                                            {{ $w->status->label() }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $w->bank_tujuan }} · {{ $w->norek_tujuan }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $w->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="mt-2 sm:mt-0">
                                    <span class="text-xs text-gray-400">—</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        @endif

        <div class="mt-4">
            {{ $withdrawals->links() }}
        </div>
    </div>
</x-app-layout>