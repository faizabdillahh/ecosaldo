<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Riwayat Setoran Saya</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        <x-table 
            :headers="[
                ['label' => 'Tanggal'],
                ['label' => 'Jenis Sampah'],
                ['label' => 'Berat', 'align' => 'text-right'],
                ['label' => 'Saldo', 'align' => 'text-right'],
            ]"
            :data="$setorans"
            emptyTitle="Belum ada setoran"
            emptyDescription="Riwayat setoran Anda akan muncul di sini"
        >
            @foreach($setorans as $s)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 text-sm">{{ $s->tanggal_setor }}</td>
                <td class="p-3 text-gray-600">{{ $s->jenisSampah->nama }}</td>
                <td class="p-3 text-right">{{ $s->berat_kg }} kg</td>
                <td class="p-3 text-right text-eco font-medium">Rp {{ number_format($s->total_saldo) }}</td>
            </tr>
            @endforeach

            <x-slot:mobile>
                @foreach($setorans as $s)
                <div class="p-4">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-gray-900">{{ $s->jenisSampah->nama }}</span>
                        <span class="text-eco font-medium">Rp {{ number_format($s->total_saldo) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ $s->berat_kg }} kg</span>
                        <span>{{ $s->tanggal_setor }}</span>
                    </div>
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>