<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900">Katalog Reward</h2>
            <a href="{{ route('reward.create') }}">
                <x-button size="sm">+ Tambah</x-button>
            </a>
        </div>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <x-table 
            :headers="[
                ['label' => 'Nama'],
                ['label' => 'Poin', 'align' => 'text-right'],
                ['label' => 'Stok', 'align' => 'text-center'],
                ['label' => 'Jenis', 'align' => 'text-center'],
                ['label' => 'Aksi', 'align' => 'text-right'],
            ]"
            :data="$rewards"
            emptyTitle="Belum ada reward"
            emptyDescription="Tambahkan reward untuk nasabah"
        >
            @foreach($rewards as $r)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 font-medium text-gray-900">{{ $r->nama }}</td>
                <td class="p-3 text-right">{{ number_format($r->poin_dibutuhkan) }}</td>
                <td class="p-3 text-center">{{ $r->stok }}</td>
                <td class="p-3 text-center">
                    <x-badge :status="$r->jenis" type="reward" />
                </td>
                <td class="p-3 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('reward.edit', $r) }}" class="text-finance text-sm hover:underline">Edit</a>
                        <form action="{{ route('reward.destroy', $r) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm hover:underline" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach

            <x-slot:mobile>
                @foreach($rewards as $r)
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-900">{{ $r->nama }}</span>
                        <x-badge :status="$r->jenis" type="reward" />
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                        <span>{{ number_format($r->poin_dibutuhkan) }} poin</span>
                        <span>Stok: {{ $r->stok }}</span>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('reward.edit', $r) }}" class="text-finance text-sm">Edit</a>
                        <form action="{{ route('reward.destroy', $r) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>