<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Tukar Reward</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        <div class="bg-finance text-white rounded-2xl p-4 sm:p-6 shadow-lg mb-6">
            <p class="text-sm opacity-80">Saldo Anda</p>
            <p class="text-2xl sm:text-3xl font-bold">Rp {{ number_format($saldo) }}</p>
        </div>

        @if(session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($rewards as $r)
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">{{ $r->nama }}</h3>
                    <x-badge :status="$r->jenis" type="reward" />
                </div>
                <p class="text-sm text-gray-500 mb-3">{{ $r->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                <div class="flex items-center justify-between text-sm mb-4">
                    <span class="text-gray-500">{{ number_format($r->poin_dibutuhkan) }} poin</span>
                    <span class="text-gray-400">Stok: {{ $r->stok }}</span>
                </div>
                <form action="{{ route('redemption.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reward_id" value="{{ $r->id }}">
                    <x-button type="submit" class="w-full" color="eco" :disabled="$saldo < $r->poin_dibutuhkan">
                        Tukar
                    </x-button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>