<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'poin_dibutuhkan', 'stok', 'jenis'];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }
}