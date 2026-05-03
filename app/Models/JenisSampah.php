<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    protected $fillable = [
        'nama',
        'harga_per_kg',
        'kategori',
    ];

    protected function casts(): array
    {
        return [
            'harga_per_kg' => 'integer',
        ];
    }

    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }
}