<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Verifikasi Penarikan</h2>
    </x-slot>

    <div class="py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Nasabah</th>
                    <th class="p-2 border">Jumlah</th>
                    <th class="p-2 border">Bank</th>
                    <th class="p-2 border">Rekening</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $w)
                <tr>
                    <td class="p-2 border">{{ $w->user->name }}</td>
                    <td class="p-2 border">Rp {{ number_format($w->jumlah) }}</td>
                    <td class="p-2 border">{{ $w->bank_tujuan }}</td>
                    <td class="p-2 border">{{ $w->norek_tujuan }}</td>
                    <td class="p-2 border">{{ ucfirst($w->status) }}</td>
                    <td class="p-2 border">
                        @if($w->status === 'pending')
                            <form action="{{ route('admin.withdrawal.verify', $w) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm">Setujui</button>
                            </form>
                        @else
                            {{ ucfirst($w->status) }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $withdrawals->links() }}
    </div>
</x-app-layout>