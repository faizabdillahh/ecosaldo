<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Verifikasi Penukaran</h2>
    </x-slot>

    <div class="py-6 px-4">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nasabah</th>
                    <th class="p-2 border">Reward</th>
                    <th class="p-2 border">Poin</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($redemptions as $r)
                <tr>
                    <td class="p-2 border">{{ $r->user->name }}</td>
                    <td class="p-2 border">{{ $r->reward->nama }}</td>
                    <td class="p-2 border">{{ number_format($r->poin_dipakai) }}</td>
                    <td class="p-2 border">{{ $r->status->label() }}</td>
                    <td class="p-2 border">
                        @if($r->status === \App\Enums\RedemptionStatus::MENUNGGU)
                        <form action="{{ route('admin.redemption.proses', $r) }}" method="POST" class="inline">
                            @csrf <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs">Proses</button>
                        </form>
                        @elseif($r->status === \App\Enums\RedemptionStatus::DIPROSES)
                        <form action="{{ route('admin.redemption.selesaikan', $r) }}" method="POST" class="inline">
                            @csrf <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">Selesai</button>
                        </form>
                        @endif

                        @if(in_array($r->status, [\App\Enums\RedemptionStatus::MENUNGGU, \App\Enums\RedemptionStatus::DIPROSES]))
                        <form action="{{ route('admin.redemption.tolak', $r) }}" method="POST" class="inline">
                            @csrf <button class="bg-red-600 text-white px-2 py-1 rounded text-xs">Tolak</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $redemptions->links() }}
    </div>
</x-app-layout>