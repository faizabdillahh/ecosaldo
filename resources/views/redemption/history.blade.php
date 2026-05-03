<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Penukaran</h2>
    </x-slot>

    <div class="py-6 px-4">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Reward</th>
                    <th class="p-2 border">Poin</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($redemptions as $r)
                <tr>
                    <td class="p-2 border">{{ $r->created_at->format('d/m/Y') }}</td>
                    <td class="p-2 border">{{ $r->reward->nama }}</td>
                    <td class="p-2 border">{{ number_format($r->poin_dipakai) }}</td>
                    <td class="p-2 border">{{ $r->status->label() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $redemptions->links() }}
    </div>
</x-app-layout>