<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Riwayat Penarikan</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <x-table 
            :headers="[
                ['label' => 'Tanggal'],
                ['label' => 'Jumlah', 'align' => 'text-right'],
                ['label' => 'Bank'],
                ['label' => 'Status', 'align' => 'text-center'],
            ]"
            :data="$withdrawals"
            emptyTitle="Belum ada penarikan"
            emptyDescription="Riwayat penarikan saldo akan muncul di sini"
        >
            @foreach($withdrawals as $w)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 text-sm">{{ $w->created_at->format('d/m/Y H:i') }}</td>
                <td class="p-3 text-right font-medium">Rp {{ number_format($w->jumlah) }}</td>
                <td class="p-3 text-gray-600 text-sm">{{ $w->bank_tujuan }}</td>
                <td class="p-3 text-center">
                    <x-badge :status="$w->status" type="withdrawal" />
                </td>
            </tr>
            @endforeach

            <x-slot:mobile>
                @foreach($withdrawals as $w)
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-900">Rp {{ number_format($w->jumlah) }}</span>
                        <x-badge :status="$w->status" type="withdrawal" />
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ $w->bank_tujuan }}</span>
                        <span>{{ $w->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>