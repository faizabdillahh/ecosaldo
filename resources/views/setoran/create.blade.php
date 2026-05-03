<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Input Setoran Sampah</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <form action="{{ route('setoran.store') }}" method="POST" class="bg-white border border-gray-200 rounded-xl p-6">
            @csrf

            <x-select 
                label="Nasabah"
                name="user_id"
                :options="$nasabahs->pluck('name', 'id')->toArray()"
                placeholder="-- Pilih Nasabah --"
            />

            <div class="mt-4">
                <label class="text-xs font-medium text-gray-500 block mb-1">Jenis Sampah</label>
                <select name="jenis_sampah_id" id="jenis_sampah_id" class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($jenisSampahs as $j)
                        <option value="{{ $j->id }}" data-harga="{{ $j->harga_per_kg }}">
                            {{ $j->nama }} - Rp {{ number_format($j->harga_per_kg) }}/kg
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input label="Berat (kg)" name="berat_kg" id="berat_kg" type="number" step="0.01" :required="true" />
            </div>

            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                <span class="text-sm text-gray-500">Total Saldo:</span>
                <span id="total_display" class="text-xl font-bold text-eco">Rp 0</span>
            </div>

            <div class="mt-6">
                <x-button type="submit">
                    Simpan Setoran
                </x-button>
            </div>
        </form>
    </div>

    <script>
        const hargaSelect = document.getElementById('jenis_sampah_id');
        const beratInput = document.getElementById('berat_kg');
        const totalDisplay = document.getElementById('total_display');

        function hitung() {
            const option = hargaSelect.selectedOptions[0];
            const harga = option ? option.dataset.harga : 0;
            const berat = beratInput.value || 0;
            const total = harga * berat;
            totalDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        hargaSelect.addEventListener('change', hitung);
        beratInput.addEventListener('input', hitung);
    </script>
</x-app-layout>