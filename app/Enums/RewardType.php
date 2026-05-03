<?php

namespace App\Enums;

enum RewardType: string
{
    case FISIK = 'fisik';
    case DIGITAL = 'digital';

    public function label(): string
    {
        return match ($this) {
            self::FISIK => 'Fisik',
            self::DIGITAL => 'Digital',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case): array => [$case->value => $case->label()])
            ->toArray();
    }
}
