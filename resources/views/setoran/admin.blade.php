<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Semua Setoran Nasabah</h2>
    </x-slot>

    <div class="py-6 px-4">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Nasabah</th>
                    <th class="p-2 border">Jenis</th>
                    <th class="p-2 border">Berat</th>
                    <th class="p-2 border">Saldo</th>
                    <th class="p-2 border">Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($setorans as $s)
                <tr>
                    <td class="p-2 border">{{ $s->tanggal_setor }}</td>
                    <td class="p-2 border">{{ $s->user->name }}</td>
                    <td class="p-2 border">{{ $s->jenisSampah->nama }}</td>
                    <td class="p-2 border">{{ $s->berat_kg }} kg</td>
                    <td class="p-2 border">Rp {{ number_format($s->total_saldo) }}</td>
                    <td class="p-2 border">{{ $s->admin->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $setorans->links() }}
    </div>
</x-app-layout>