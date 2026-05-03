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
}