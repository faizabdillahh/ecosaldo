<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tarik Saldo</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-md">
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <div class="mb-4 p-3 bg-gray-100 rounded">
            <p class="text-sm">Saldo Tersedia:</p>
            <p class="text-2xl font-bold">Rp {{ number_format($user->setorans()->sum('total_saldo') - $user->withdrawals()->where('status', 'success')->sum('jumlah')) }}</p>
        </div>

        <div class="mb-4 p-3 bg-gray-50 rounded text-sm">
            <p>Bank: <strong>{{ $user->bank_name ?? 'Belum diisi' }}</strong></p>
            <p>Rekening: <strong>{{ $user->bank_account_number ?? 'Belum diisi' }}</strong></p>
        </div>

        <form action="{{ route('withdrawal.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium">Jumlah Penarikan</label>
                <input type="number" name="jumlah" class="w-full border rounded p-2" min="10000" required>
                <p class="text-xs text-gray-500 mt-1">Minimal Rp 10.000</p>
                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Ajukan Tarik Saldo</button>
        </form>
    </div>
</x-app-layout>