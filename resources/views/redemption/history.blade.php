<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Riwayat Penukaran</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        <x-table 
            :headers="[
                ['label' => 'Tanggal'],
                ['label' => 'Reward'],
                ['label' => 'Poin', 'align' => 'text-right'],
                ['label' => 'Status', 'align' => 'text-center'],
            ]"
            :data="$redemptions"
            emptyTitle="Belum ada penukaran"
            emptyDescription="Riwayat penukaran reward Anda akan muncul di sini"
        >
            @foreach($redemptions as $r)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 text-sm">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                <td class="p-3 text-gray-600">{{ $r->reward->nama }}</td>
                <td class="p-3 text-right">{{ number_format($r->poin_dipakai) }}</td>
                <td class="p-3 text-center">
                    <x-badge :status="$r->status" type="redemption" />
                </td>
            </tr>
            @endforeach

            <x-slot:mobile>
                @foreach($redemptions as $r)
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-900">{{ $r->reward->nama }}</span>
                        <x-badge :status="$r->status" type="redemption" />
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ number_format($r->poin_dipakai) }} poin</span>
                        <span>{{ $r->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>