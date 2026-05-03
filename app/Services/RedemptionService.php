<?php

namespace App\Services;

use App\Enums\RedemptionStatus;
use App\Models\Redemption;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RedemptionService
{
    /**
     * Nasabah menukar reward.
     * Saldo terpotong langsung, stok berkurang.
     */
    public function redeem(User $user, Reward $reward): Redemption
    {
        if ($user->balance < $reward->poin_dibutuhkan) {
            throw new \Exception('Saldo tidak mencukupi.');
        }

        if ($reward->stok < 1) {
            throw new \Exception('Stok habis.');
        }

        return DB::transaction(function () use ($user, $reward) {
            $redemption = Redemption::create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
                'poin_dipakai' => $reward->poin_dibutuhkan,
                'status' => RedemptionStatus::MENUNGGU,
            ]);

            $reward->decrement('stok');

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
     * Admin batalkan penukaran. Stok kembali.
     */
    public function cancel(Redemption $redemption): void
    {
        DB::transaction(function () use ($redemption) {
            $redemption->reward->increment('stok');
            $redemption->update(['status' => RedemptionStatus::DIBATALKAN]);
        });
    }
}