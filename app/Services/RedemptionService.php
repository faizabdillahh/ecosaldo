<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RedemptionStatus;
use App\Models\Redemption;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RedemptionService
{
    /**
     * Nasabah menukar reward — bisa lebih dari 1.
     * Saldo terpotong langsung, stok berkurang.
     */
    public function redeem(User $user, Reward $reward, int $quantity = 1): Redemption
    {
        $totalPoin = $reward->poin_dibutuhkan * $quantity;

        if ($user->balance < $totalPoin) {
            throw new \Exception('Saldo tidak mencukupi.');
        }

        if ($reward->stok < $quantity) {
            throw new \Exception('Stok tidak mencukupi.');
        }

        return DB::transaction(function () use ($user, $reward, $totalPoin, $quantity) {
            $redemption = Redemption::create([
                'user_id'      => $user->id,
                'reward_id'    => $reward->id,
                'poin_dipakai' => $totalPoin,
                'status'       => RedemptionStatus::MENUNGGU,
            ]);

            $reward->decrement('stok', $quantity);

            return $redemption;
        });
    }

    /**
     * Admin proses penukaran.
     */
    public function process(Redemption $redemption): void
    {
        $redemption->update(['status' => RedemptionStatus::DIPROSES]);
    }

    /**
     * Admin selesaikan penukaran.
     */
    public function complete(Redemption $redemption): void
    {
        $redemption->update(['status' => RedemptionStatus::SELESAI]);
    }

    /**
     * Admin batalkan penukaran. Stok kembali sesuai quantity.
     */
    public function cancel(Redemption $redemption): void
    {
        DB::transaction(function () use ($redemption) {
            $quantity = (int) ($redemption->poin_dipakai / $redemption->reward->poin_dibutuhkan);

            $redemption->reward->increment('stok', $quantity);
            $redemption->update(['status' => RedemptionStatus::DIBATALKAN]);
        });
    }
}