<?php

namespace App\Models;

use App\Enums\RedemptionStatus;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    protected $fillable = [
        'user_id',
        'reward_id',
        'poin_dipakai',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'status' => RedemptionStatus::class,
            'poin_dipakai' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }

    /**
     * Scope: yang tidak dibatalkan (mengurangi saldo).
     */
    public function scopeMengurangiSaldo($query)
    {
        return $query->whereNotIn('status', [RedemptionStatus::DIBATALKAN]);
    }
}