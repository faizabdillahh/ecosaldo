@props([
    'name' => '',
    'size' => 'md',
])

@php
    $sizes = match ($size) {
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-lg',
        default => 'w-10 h-10 text-sm',
    };
    
    $initial = strtoupper(substr($name, 0, 1));
@endphp

<div {{ $attributes->merge(['class' => "{$sizes} bg-eco-50 text-eco rounded-full flex items-center justify-center font-bold"]) }}>
    {{ $initial }}
</div>