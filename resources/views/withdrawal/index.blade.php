<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Penarikan</h2>
    </x-slot>

    <div class="py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Bank</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $w)
                <tr>
                    <td class="p-2 border">{{ $w->created_at->format('d/m/Y') }}</td>
                    <td class="p-2 border">Rp {{ number_format($w->jumlah) }}</td>
                    <td class="p-2 border">{{ $w->bank_tujuan }}</td>
                    <td class="p-2 border">{{ ucfirst($w->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $withdrawals->links() }}
    </div>
</x-app-layout>