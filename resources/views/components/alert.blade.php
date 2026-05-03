@props([
    'type' => 'success',
    'dismissible' => true,
])

@php
    $styles = match ($type) {
        'success' => 'bg-eco-50 text-eco-800 border-eco-200',
        'error' => 'bg-red-50 text-red-700 border-red-200',
        'warning' => 'bg-warning-50 text-warning-800 border-warning-200',
        'info' => 'bg-finance-50 text-finance-800 border-finance-200',
        default => 'bg-gray-50 text-gray-700 border-gray-200',
    };
@endphp

<div x-data="{ show: true }" x-show="show" 
     {{ $attributes->merge(['class' => "border rounded-xl p-3 text-sm flex items-center gap-2 {$styles}"]) }}>
    <div class="flex-1">{{ $slot }}</div>
    @if($dismissible)
        <button @click="show = false" class="shrink-0 text-current opacity-50 hover:opacity-100">&times;</button>
    @endif
</div>