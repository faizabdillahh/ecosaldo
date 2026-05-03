<?php

namespace App\Models;

use App\Enums\RewardType;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'poin_dibutuhkan',
        'stok',
        'jenis',
    ];

    protected function casts(): array
    {
        return [
            'jenis' => RewardType::class,
            'poin_dibutuhkan' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    /**
     * Scope: stok tersedia.
     */
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
}