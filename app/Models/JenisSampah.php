<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    protected $fillable = ['nama', 'harga_per_kg', 'kategori'];

    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }
}