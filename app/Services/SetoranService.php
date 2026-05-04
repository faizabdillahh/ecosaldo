<?php

namespace App\Services;

use App\Models\JenisSampah;
use App\Models\Setoran;

class SetoranService
{
    /**
     * Catat setoran baru & hitung total saldo.
     */
    public function create(int $nasabahId, int $adminId, JenisSampah $jenisSampah, float $beratKg): Setoran
    {
        $totalSaldo = (int) ($jenisSampah->harga_per_kg * $beratKg);

        return Setoran::create([
            'user_id'        => $nasabahId,
            'admin_id'       => $adminId,
            'jenis_sampah_id' => $jenisSampah->id,
            'berat_kg'       => $beratKg,
            'total_saldo'    => $totalSaldo,
            'tanggal_setor'  => now()->toDateString(),
        ]);
    }
}