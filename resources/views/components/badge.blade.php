@props([
    'status' => null,
    'type' => 'withdrawal',
    'class' => '',
])

@php
    // Ambil value & label dari status
    if ($status instanceof \App\Enums\WithdrawalStatus 
        || $status instanceof \App\Enums\RedemptionStatus 
        || $status instanceof \App\Enums\RewardType
    ) {
        $value = $status->value;
        $label = $status->label();
    } else {
        $value = is_string($status) ? strtolower($status) : '';
        $label = is_string($status) ? ucfirst($status) : 'Unknown';
    }

    // Warna berdasarkan type + value
    $colors = match ($type) {
        'withdrawal' => match ($value) {
            'pending' => 'bg-warning-50 text-warning-800 border border-warning-200',
            'processing' => 'bg-finance-50 text-finance-800 border border-finance-200',
            'verified' => 'bg-finance-50 text-finance-800 border border-finance-200',
            'success' => 'bg-eco-50 text-eco-800 border border-eco-200',
            'failed' => 'bg-red-50 text-red-700 border border-red-200',
            default => 'bg-gray-50 text-gray-600 border border-gray-200',
        },
        'redemption' => match ($value) {
            'menunggu' => 'bg-warning-50 text-warning-800 border border-warning-200',
            'diproses' => 'bg-finance-50 text-finance-800 border border-finance-200',
            'selesai' => 'bg-eco-50 text-eco-800 border border-eco-200',
            'dibatalkan' => 'bg-red-50 text-red-700 border border-red-200',
            default => 'bg-gray-50 text-gray-600 border border-gray-200',
        },
        'reward' => match ($value) {
            'fisik' => 'bg-blue-50 text-blue-700 border border-blue-200',
            'digital' => 'bg-purple-50 text-purple-700 border border-purple-200',
            default => 'bg-gray-50 text-gray-600 border border-gray-200',
        },
        default => 'bg-gray-50 text-gray-600 border border-gray-200',
    };
@endphp

<span 
    {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colors} {$class}"]) }}
    role="status"
>
    {{ $label }}
</span>