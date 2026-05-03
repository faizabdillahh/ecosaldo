@props([
    'color' => 'eco',
    'type' => 'submit',
    'size' => 'md',
    'ariaLabel' => null,
])

@php
    $colors = match ($color) {
        'eco' => 'bg-eco text-white hover:bg-eco-700',
        'finance' => 'bg-finance text-white hover:bg-finance-700',
        'warning' => 'bg-warning text-white hover:bg-warning-700',
        'reward' => 'bg-reward text-white hover:bg-reward-700',
        'red' => 'bg-red-600 text-white hover:bg-red-700',
        'gray' => 'bg-gray-100 text-gray-700 hover:bg-gray-200',
        default => 'bg-eco text-white hover:bg-eco-700',
    };
    
    $sizes = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };
@endphp

<button 
    type="{{ $type }}"
    @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center font-semibold rounded-lg transition {$colors} {$sizes}"]) }}
>
    {{ $slot }}
</button>