@props([
'label' => '',
'value' => 0,
'icon' => null,
'color' => 'gray',
])

@php
$colors = match ($color) {
'eco' => 'bg-eco-50 text-eco border-eco-200',
'finance' => 'bg-finance-50 text-finance border-finance-200',
'warning' => 'bg-warning-50 text-warning border-warning-200',
'reward' => 'bg-reward-50 text-reward border-reward-200',
default => 'bg-gray-50 text-gray-700 border-gray-200',
};
@endphp

<div {{ $attributes->merge(['class' => "bg-white border rounded-xl p-3 sm:p-4 text-center shadow-sm hover:shadow-md
    transition {$colors}"]) }}>
    @if($icon)
    <div class="mx-auto mb-1">{!! $icon !!}</div>
    @endif <p class="text-xl sm:text-2xl font-bold">{{ $value }}</p>
    <p class="text-xs text-gray-500 mt-1">{{ $label }}</p>
</div>