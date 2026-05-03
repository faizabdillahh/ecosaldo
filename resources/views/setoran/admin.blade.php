<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Semua Setoran</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-700 text-white text-xs uppercase tracking-wider">
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Nasabah</th>
                            <th class="p-3 text-left hidden sm:table-cell">Jenis</th>
                            <th class="p-3 text-right">Berat</th>
                            <th class="p-3 text-right hidden sm:table-cell">Saldo</th>
                            <th class="p-3 text-right hidden sm:table-cell">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($setorans as $s)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3">
                                <span class="font-medium">{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</span>
                            </td>
                            <td class="p-3">
                                <span class="font-medium">{{ $s->user->name }}</span>
                                <span class="block text-xs text-gray-500 sm:hidden">
                                    {{ $s->jenisSampah->nama }} · {{ $s->berat_kg }} kg · Rp {{ number_format($s->total_saldo) }}
                                </span>
                            </td>
                            <td class="p-3 hidden sm:table-cell text-gray-600">{{ $s->jenisSampah->nama }}</td>
                            <td class="p-3 text-right font-medium">{{ $s->berat_kg }} kg</td>
                            <td class="p-3 text-right hidden sm:table-cell text-eco font-medium">Rp {{ number_format($s->total_saldo) }}</td>
                            <td class="p-3 text-right hidden sm:table-cell text-gray-500 text-xs">{{ $s->admin->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            {{ $setorans->links() }}
        </div>
    </div>
</x-app-layout>