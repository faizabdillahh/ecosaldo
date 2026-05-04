<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\WithdrawalStatus;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WithdrawalService
{
    /**
     * Buat pengajuan tarik saldo baru.
     */
    public function create(User $user, int $jumlah): Withdrawal
    {
        if ($user->withdrawals()->where('status', WithdrawalStatus::PENDING)->exists()) {
            throw new \Exception('Masih ada pengajuan yang belum diproses.');
        }

        return Withdrawal::create([
            'user_id'      => $user->id,
            'jumlah'       => $jumlah,
            'status'       => WithdrawalStatus::PENDING,
            'bank_tujuan'  => $user->bank_name,
            'norek_tujuan' => $user->bank_account_number,
        ]);
    }

    /**
     * Verifikasi penarikan (approve by admin).
     * TODO: Integrasi Midtrans Iris.
     */
    public function verify(Withdrawal $withdrawal): void
    {
        $withdrawal->update([
            'status'      => WithdrawalStatus::SUCCESS,
            'midtrans_id' => 'manual-' . uniqid(),
        ]);
    }

    /**
     * Ambil data penarikan dengan filter.
     */
    public function getFiltered(array $filters): LengthAwarePaginator
    {
        $query = Withdrawal::with('user');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['month'])) {
            $date = Carbon::parse($filters['month']);
            $query->whereMonth('created_at', $date->month)
                  ->whereYear('created_at', $date->year);
        }

        return $query
            ->orderByRaw("FIELD(status, '" . $this->statusOrder() . "')")
            ->latest()
            ->paginate(10);
    }

    /**
     * Urutan status untuk sorting.
     */
    private function statusOrder(): string
    {
        return implode("','", array_map(
            fn(WithdrawalStatus $s): string => $s->value,
            WithdrawalStatus::cases()
        ));
    }
}