<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Jenis Sampah</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-md">
        <form action="{{ route('jenis-sampah.update', $jenisSampah) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="block text-sm">Nama</label>
                <input type="text" name="nama" value="{{ $jenisSampah->nama }}" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Harga per Kg</label>
                <input type="number" name="harga_per_kg" value="{{ $jenisSampah->harga_per_kg }}" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Kategori</label>
                <input type="text" name="kategori" value="{{ $jenisSampah->kategori }}" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>