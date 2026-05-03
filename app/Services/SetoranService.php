<?php

namespace App\Services;

use App\Models\JenisSampah;
use App\Models\Setoran;
use Illuminate\Database\Eloquent\Collection;

class SetoranService
{
    /**
     * Catat setoran baru & hitung total saldo.
     */
    public function create(int $nasabahId, int $adminId, JenisSampah $jenisSampah, float $beratKg): Setoran
    {
        $totalSaldo = (int) ($jenisSampah->harga_per_kg * $beratKg);

        return Setoran::create([
            'user_id' => $nasabahId,
            'admin_id' => $adminId,
            'jenis_sampah_id' => $jenisSampah->id,
            'berat_kg' => $beratKg,
            'total_saldo' => $totalSaldo,
            'tanggal_setor' => now()->toDateString(),
        ]);
    }

    /**
     * Hitung saldo nasabah (total setoran - total penarikan sukses - reward).
     */
    public function getBalance(int $userId): int
    {
        $totalSetoran = Setoran::where('user_id', $userId)->sum('total_saldo');
        // Pending & verified & processing juga dianggap mengurangi saldo
        $totalPenarikan = \App\Models\Withdrawal::where('user_id', $userId)
            ->whereIn('status', ['pending', 'verified', 'processing', 'success'])
            ->sum('jumlah');
        $totalReward = \App\Models\Redemption::where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'diproses', 'selesai'])
            ->sum('poin_dipakai');

        return $totalSetoran - $totalPenarikan - $totalReward;
    }
}