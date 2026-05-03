@props([
    'icon' => null,
    'title' => 'Tidak ada data',
    'description' => null,
])

<div 
    {{ $attributes->merge(['class' => 'text-center py-12 px-4']) }}
    role="status"
    aria-label="{{ $title }}"
>
    @if($icon)
        <div class="text-4xl mb-4">{{ $icon }}</div>
    @else
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>
    @endif

    <h3 class="text-sm font-semibold text-gray-700">{{ $title }}</h3>

    @if($description)
        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">{{ $description }}</p>
    @endif

    @if(isset($slot) && $slot->isNotEmpty())
        <div class="mt-6">
            {{ $slot }}
        </div>
    @endif
</div>