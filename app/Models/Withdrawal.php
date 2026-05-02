<?php

namespace App\Models;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}