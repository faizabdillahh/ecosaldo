<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg md:text-xl font-semibold text-gray-900">Verifikasi Penukaran</h2>
    </x-slot>

    <div class="py-4 md:py-6 px-3 md:px-4">
        <x-table 
            :headers="[
                ['label' => 'Nasabah'],
                ['label' => 'Reward'],
                ['label' => 'Poin', 'align' => 'text-right'],
                ['label' => 'Jumlah', 'align' => 'text-center'],
                ['label' => 'Status', 'align' => 'text-center'],
                ['label' => 'Aksi', 'align' => 'text-right'],
            ]"
            :data="$redemptions"
            emptyTitle="Belum ada penukaran"
            emptyDescription="Penukaran reward nasabah akan muncul di sini"
        >
            @foreach($redemptions as $r)
            @php $qty = (int) ($r->poin_dipakai / $r->reward->poin_dibutuhkan); @endphp
            <tr class="hover:bg-gray-50 transition">
                <td class="p-3 font-medium text-gray-900">{{ $r->user->name }}</td>
                <td class="p-3 text-gray-600">{{ $r->reward->nama }}</td>
                <td class="p-3 text-right">{{ number_format($r->poin_dipakai) }}</td>
                <td class="p-3 text-center text-sm font-medium">{{ $qty }}x</td>
                <td class="p-3 text-center">
                    <x-badge :status="$r->status" type="redemption" />
                </td>
                <td class="p-3 text-right">
                    <div class="flex justify-end gap-1">
                        @if($r->status === \App\Enums\RedemptionStatus::MENUNGGU)
                            <form action="{{ route('admin.redemption.proses', $r) }}" method="POST">
                                @csrf
                                <x-button type="submit" size="sm" color="finance">Proses</x-button>
                            </form>
                        @elseif($r->status === \App\Enums\RedemptionStatus::DIPROSES)
                            <form action="{{ route('admin.redemption.selesaikan', $r) }}" method="POST">
                                @csrf
                                <x-button type="submit" size="sm">Selesai</x-button>
                            </form>
                        @endif
                        @if(in_array($r->status, [\App\Enums\RedemptionStatus::MENUNGGU, \App\Enums\RedemptionStatus::DIPROSES]))
                            <form action="{{ route('admin.redemption.tolak', $r) }}" method="POST">
                                @csrf
                                <x-button type="submit" size="sm" color="red">Tolak</x-button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach

            <x-slot:mobile>
                @foreach($redemptions as $r)
                @php $qty = (int) ($r->poin_dipakai / $r->reward->poin_dibutuhkan); @endphp
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span class="font-semibold text-gray-900">{{ $r->user->name }}</span>
                            <p class="text-sm text-gray-500">{{ $r->reward->nama }} · {{ $qty }}x</p>
                        </div>
                        <x-badge :status="$r->status" type="redemption" />
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">{{ number_format($r->poin_dipakai) }} poin</span>
                        <div class="flex gap-1">
                            @if($r->status === \App\Enums\RedemptionStatus::MENUNGGU)
                                <form action="{{ route('admin.redemption.proses', $r) }}" method="POST">
                                    @csrf
                                    <x-button type="submit" size="sm" color="finance">Proses</x-button>
                                </form>
                            @elseif($r->status === \App\Enums\RedemptionStatus::DIPROSES)
                                <form action="{{ route('admin.redemption.selesaikan', $r) }}" method="POST">
                                    @csrf
                                    <x-button type="submit" size="sm">Selesai</x-button>
                                </form>
                            @endif
                            @if(in_array($r->status, [\App\Enums\RedemptionStatus::MENUNGGU, \App\Enums\RedemptionStatus::DIPROSES]))
                                <form action="{{ route('admin.redemption.tolak', $r) }}" method="POST">
                                    @csrf
                                    <x-button type="submit" size="sm" color="red">Tolak</x-button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </x-slot:mobile>
        </x-table>
    </div>
</x-app-layout>