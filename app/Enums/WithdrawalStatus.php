<?php

namespace App\Enums;

enum WithdrawalStatus: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case PROCESSING = 'processing';
    case SUCCESS = 'success';
    case FAILED = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::VERIFIED => 'Verified',
            self::PROCESSING => 'Processing',
            self::SUCCESS => 'Success',
            self::FAILED => 'Failed',
        };
    }
}