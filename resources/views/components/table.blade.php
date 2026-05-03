@props([
    'headers' => [],
    'data' => null,
    'emptyTitle' => 'Tidak ada data',
    'emptyDescription' => null,
])

@if($data && $data->count() > 0)
    <div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden']) }}>

        {{-- Mobile: Card List --}}
        @if(isset($mobile))
            <div class="sm:hidden divide-y divide-gray-100" role="list" aria-label="Mobile data list">
                {{ $mobile }}
            </div>
        @endif

        {{-- Desktop: Table --}}
        <div class="{{ isset($mobile) ? 'hidden sm:block' : '' }} overflow-x-auto">
            <table class="w-full text-sm" role="table" aria-label="Data table">
                <thead>
                    <tr class="bg-gray-700 text-white text-xs uppercase tracking-wider">
                        @foreach($headers as $header)
                            <th class="p-3 whitespace-nowrap {{ $header['align'] ?? 'text-left' }}" scope="col">
                                {{ $header['label'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{ $slot }}
                </tbody>
            </table>
        </div>

    </div>

    @if(method_exists($data, 'links'))
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    @endif
@else
    <x-empty-state 
        :title="$emptyTitle" 
        :description="$emptyDescription" 
    />
@endif