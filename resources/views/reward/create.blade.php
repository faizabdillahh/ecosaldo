<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Reward</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-md">
        <form action="{{ route('reward.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm">Nama</label>
                <input type="text" name="nama" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border rounded p-2" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Poin Dibutuhkan</label>
                <input type="number" name="poin_dibutuhkan" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Stok</label>
                <input type="number" name="stok" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm">Jenis</label>
                <select name="jenis" class="w-full border rounded p-2" required>
                    @foreach(\App\Enums\RewardType::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>