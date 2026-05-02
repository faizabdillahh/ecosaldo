<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'jenis_sampah_id',
        'berat_kg',
        'total_saldo',
        'tanggal_setor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }
}