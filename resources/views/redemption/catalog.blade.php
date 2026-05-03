<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tukar Reward</h2>
    </x-slot>

    <div class="py-6 px-4">
        <div class="mb-4 p-3 bg-gray-100 rounded">
            Saldo Anda: <strong>Rp {{ number_format($saldo) }}</strong>
        </div>

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-2 gap-4">
            @foreach($rewards as $r)
            <div class="border p-4 rounded shadow">
                <h3 class="font-semibold">{{ $r->nama }}</h3>
                <p class="text-sm text-gray-600">{{ $r->deskripsi }}</p>
                <p class="text-sm">Poin: <strong>{{ number_format($r->poin_dibutuhkan) }}</strong></p>
                <p class="text-sm">Stok: {{ $r->stok }}</p>
                <form action="{{ route('redemption.store') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="reward_id" value="{{ $r->id }}">
                    <button class="bg-green-600 text-white px-4 py-1 rounded text-sm"
                        {{ $saldo < $r->poin_dibutuhkan ? 'disabled' : '' }}>
                        Tukar
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>