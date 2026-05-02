<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Jenis Sampah</h2>
    </x-slot>

    <div class="py-6 px-4">
        <a href="{{ route('jenis-sampah.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah</a>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mt-3 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full mt-4 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Harga/kg</th>
                    <th class="p-2 border">Kategori</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jenisSampahs as $item)
                <tr>
                    <td class="p-2 border">{{ $item->nama }}</td>
                    <td class="p-2 border">Rp {{ number_format($item->harga_per_kg) }}</td>
                    <td class="p-2 border">{{ $item->kategori }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('jenis-sampah.edit', $item) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('jenis-sampah.destroy', $item) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 ml-2" onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>