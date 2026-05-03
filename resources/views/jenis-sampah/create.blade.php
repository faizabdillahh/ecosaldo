<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Tambah Jenis Sampah</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        <form action="{{ route('jenis-sampah.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6">
            @csrf
            <x-input label="Nama" name="nama" :required="true" />
            <div class="mt-4">
                <x-input label="Harga per Kg" name="harga_per_kg" type="number" :required="true" />
            </div>
            <div class="mt-4">
                <x-input label="Kategori" name="kategori" placeholder="Contoh: Plastik, Kertas, Logam" />
            </div>
            <div class="mt-6">
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </div>
</x-app-layout>