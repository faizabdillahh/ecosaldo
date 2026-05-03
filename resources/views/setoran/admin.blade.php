<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Semua Setoran</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        <x-table :headers="[
                ['label' => 'Tanggal'],
                ['label' => 'Nasabah'],
                ['label' => 'Jenis'],
                ['label' => 'Berat', 'align' => 'text-right'],
                ['label' => 'Saldo', 'align' => 'text-right'],
                ['label' => 'Petugas', 'align' => 'text-right'],
            ]" :data="$setorans" emptyTitle="Belum ada setoran" emptyDescription="Setoran nasabah akan muncul di sini">
            @foreach($setorans as $s)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 text-sm">{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</td>
                <td class="p-3 font-medium text-gray-900">{{ $s->user->name }}</td>
                <td class="p-3 text-gray-600 text-sm">{{ $s->jenisSampah->nama }}</td>
                <td class="p-3 text-right">{{ $s->berat_kg }} kg</td>
                <td class="p-3 text-right text-eco font-medium">Rp {{ number_format($s->total_saldo) }}</td>
                <td class="p-3 text-right text-gray-500 text-xs">{{ $s->admin->name ?? '-' }}</td>
            </tr>
            @endforeach

            <x-slot:mobile>
                @foreach($setorans as $s)
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-900">{{ $s->user->name }}</span>
                        <span class="text-eco font-medium">Rp {{ number_format($s->total_saldo) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ $s->jenisSampah->nama }} · {{ $s->berat_kg }} kg</span>
                        <span>{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</span>
                    </div>
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>