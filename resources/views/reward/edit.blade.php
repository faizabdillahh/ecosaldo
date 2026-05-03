<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Edit Reward</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        <form action="{{ route('reward.update', $reward) }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6">
            @csrf @method('PUT')
            <x-input label="Nama" name="nama" :value="$reward->nama" :required="true" />
            <div class="mt-4">
                <label class="text-xs font-medium text-gray-500 block mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="2" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5">{{ $reward->deskripsi }}</textarea>
            </div>
            <div class="mt-4">
                <x-input label="Poin Dibutuhkan" name="poin_dibutuhkan" type="number" :value="$reward->poin_dibutuhkan" :required="true" />
            </div>
            <div class="mt-4">
                <x-input label="Stok" name="stok" type="number" :value="$reward->stok" :required="true" />
            </div>
            <div class="mt-4">
                <x-select 
                    label="Jenis"
                    name="jenis"
                    :options="\App\Enums\RewardType::options()"
                    :selected="$reward->jenis->value"
                />
            </div>
            <div class="mt-6">
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </div>
</x-app-layout>