<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg md:text-xl font-semibold text-gray-900">Jenis Sampah</h2>
            <a href="{{ route('jenis-sampah.create') }}">
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
                ['label' => 'Harga/kg', 'align' => 'text-right'],
                ['label' => 'Kategori'],
                ['label' => 'Aksi', 'align' => 'text-right'],
            ]"
            :data="$jenisSampahs"
            emptyTitle="Belum ada jenis sampah"
            emptyDescription="Tambahkan jenis sampah dan harga per kg"
        >
            @foreach($jenisSampahs as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 font-medium text-gray-900">{{ $item->nama }}</td>
                <td class="p-3 text-right">Rp {{ number_format($item->harga_per_kg) }}</td>
                <td class="p-3 text-gray-600">{{ $item->kategori ?? '-' }}</td>
                <td class="p-3 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('jenis-sampah.edit', $item) }}" class="text-finance text-sm hover:underline">Edit</a>
                        <form action="{{ route('jenis-sampah.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 text-sm hover:underline" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
    </div>
</x-app-layout>