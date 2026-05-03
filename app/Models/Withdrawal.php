<?php

namespace App\Models;

use App\Enums\WithdrawalStatus;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'jumlah',
        'status',
        'midtrans_id',
        'bank_tujuan',
        'norek_tujuan',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => WithdrawalStatus::class,
            'jumlah' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: hanya yang pending.
     */
    public function scopePending($query)
    {
        return $query->where('status', WithdrawalStatus::PENDING);
    }

    /**
     * Scope: yang mengurangi saldo (pending, verified, processing, success).
     */
    public function scopeMengurangiSaldo($query)
    {
        return $query->whereIn('status', [
            WithdrawalStatus::PENDING,
            WithdrawalStatus::PROCESSING,
            WithdrawalStatus::SUCCESS,
        ]);
    }
}
