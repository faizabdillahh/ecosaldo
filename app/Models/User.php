<?php

namespace App\Models;

use App\Enums\WithdrawalStatus;
use App\Enums\RedemptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'bank_name',
        'bank_account_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Saldo nasabah: total setoran - penarikan - reward (kecuali dibatalkan).
     */
    public function getBalanceAttribute(): int
    {
        $totalSetoran = $this->setorans()->sum('total_saldo');

        $totalPenarikan = $this->withdrawals()
            ->whereIn('status', [
                WithdrawalStatus::PENDING,
                WithdrawalStatus::VERIFIED,
                WithdrawalStatus::PROCESSING,
                WithdrawalStatus::SUCCESS,
            ])
            ->sum('jumlah');

        $totalReward = $this->redemptions()
            ->whereNotIn('status', [RedemptionStatus::DIBATALKAN])
            ->sum('poin_dipakai');

        return $totalSetoran - $totalPenarikan - $totalReward;
    }
}