<?php

namespace App\Models;

use App\Models\Setoran;
use App\Models\Withdrawal;
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

    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

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

    public function getBalanceAttribute()
    {
        $totalSetoran = $this->setorans()->sum('total_saldo');
        $totalPenarikan = $this->withdrawals()
            ->whereIn('status', ['pending', 'verified', 'processing', 'success'])
            ->sum('jumlah');

        return $totalSetoran - $totalPenarikan;
    }
}
