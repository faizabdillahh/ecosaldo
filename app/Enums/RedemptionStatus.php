<?php

namespace App\Enums;

enum RedemptionStatus: string
{
    case MENUNGGU = 'menunggu';
    case DIPROSES = 'diproses';
    case SELESAI = 'selesai';
    case DIBATALKAN = 'dibatalkan';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::DIPROSES => 'Diproses',
            self::SELESAI => 'Selesai',
            self::DIBATALKAN => 'Dibatalkan',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case): array => [$case->value => $case->label()])
            ->toArray();
    }
}
