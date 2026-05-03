@props([
    'name' => '',
    'src' => null,
    'size' => 'md',
])

@php
    $sizes = match ($size) {
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-lg',
        default => 'w-10 h-10 text-sm',
    };
@endphp

@if($src)
    <img src="{{ $src }}" alt="{{ $name }}" {{ $attributes->merge(['class' => "{$sizes} rounded-full object-cover"]) }}>
@else
    <div {{ $attributes->merge(['class' => "{$sizes} bg-eco-50 text-eco rounded-full flex items-center justify-center font-bold"]) }}>
        {{ strtoupper(substr($name, 0, 1)) }}
    </div>
@endif