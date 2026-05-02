<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Input Setoran Sampah</h2>
    </x-slot>

    <div class="py-6 px-4 max-w-lg">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('setoran.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium">Nasabah</label>
                <select name="user_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahs as $n)
                        <option value="{{ $n->id }}">{{ $n->name }} ({{ $n->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Jenis Sampah</label>
                <select name="jenis_sampah_id" id="jenis_sampah_id" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($jenisSampahs as $j)
                        <option value="{{ $j->id }}" data-harga="{{ $j->harga_per_kg }}">
                            {{ $j->nama }} - Rp {{ number_format($j->harga_per_kg) }}/kg
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Berat (kg)</label>
                <input type="number" step="0.01" name="berat_kg" id="berat_kg" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4 p-3 bg-gray-100 rounded">
                <span class="text-sm">Total Saldo: </span>
                <span id="total_display" class="text-lg font-bold">Rp 0</span>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Simpan Setoran</button>
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