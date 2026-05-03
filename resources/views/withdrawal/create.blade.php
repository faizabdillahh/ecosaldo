<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Tarik Saldo</h2>
    </x-slot>

    <div class="py-6 md:py-8 px-4 max-w-xl mx-auto">
        @if(session('error'))
            <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        <div class="bg-finance text-white rounded-2xl p-6 shadow-lg mb-6">
            <p class="text-sm opacity-80">Saldo Tersedia</p>
            <p class="text-3xl font-bold">Rp {{ number_format($user->balance) }}</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 text-sm text-gray-600">
            <div class="flex justify-between mb-1">
                <span>Bank</span>
                <span class="font-medium text-gray-900">{{ $user->bank_name ?? 'Belum diisi' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Rekening</span>
                <span class="font-medium text-gray-900">{{ $user->bank_account_number ?? 'Belum diisi' }}</span>
            </div>
        </div>

        <form action="{{ route('withdrawal.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6">
            @csrf
            <x-input 
                label="Jumlah Penarikan" 
                name="jumlah" 
                type="number" 
                placeholder="Minimal Rp 10.000"
                :required="true"
            />
            @error('jumlah')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <x-button type="submit" class="w-full mt-6">
                Ajukan Tarik Saldo
            </x-button>
        </form>
    </div>
</x-app-layout>