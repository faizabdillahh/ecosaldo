<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Katalog Reward</h2>
    </x-slot>

    <div class="py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('reward.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Reward</a>

        <table class="w-full mt-4 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Poin</th>
                    <th class="p-2 border">Stok</th>
                    <th class="p-2 border">Jenis</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rewards as $r)
                <tr>
                    <td class="p-2 border">{{ $r->nama }}</td>
                    <td class="p-2 border">{{ number_format($r->poin_dibutuhkan) }}</td>
                    <td class="p-2 border">{{ $r->stok }}</td>
                    <td class="p-2 border">{{ ucfirst($r->jenis) }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('reward.edit', $r) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('reward.destroy', $r) }}" method="POST" class="inline">
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