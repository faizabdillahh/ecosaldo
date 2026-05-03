<?php

namespace App\Http\Controllers;

use App\Enums\WithdrawalStatus;
use App\Models\Reward;
use App\Models\Setoran;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Single action controller for dashboard.
     */
    public function __invoke(): View
    {
        $user = auth()->user();

        return $user->hasRole('admin')
            ? view('dashboard', $this->adminData())
            : view('dashboard', $this->nasabahData($user));
    }

    /**
     * Data for admin dashboard.
     */
    private function adminData(): array
    {
        return [
            'totalNasabah'        => User::role('nasabah')->count(),
            'totalSetoran'        => Setoran::count(),
            'pendingWithdrawal'   => Withdrawal::where('status', WithdrawalStatus::PENDING)->count(),
            'totalReward'         => Reward::tersedia()->count(),
            'setoranBulanan'      => $this->getSetoranBulanan(),
            'rewardPopuler'       => Reward::withCount('redemptions')
                                        ->orderByDesc('redemptions_count')
                                        ->take(5)
                                        ->get(),
            'aktivitasTerbaru'    => Setoran::with(['user', 'jenisSampah'])
                                        ->latest()
                                        ->take(5)
                                        ->get(),
        ];
    }

    /**
     * Data for nasabah dashboard.
     */
    private function nasabahData(User $user): array
    {
        return [
            'balance'          => $user->balance,
            'setoranBulanan'   => $this->getSetoranBulanan($user->id),
            'aktivitasTerbaru' => Setoran::where('user_id', $user->id)
                                        ->with('jenisSampah')
                                        ->latest()
                                        ->take(5)
                                        ->get(),
        ];
    }

    /**
     * Monthly setoran aggregation.
     */
    private function getSetoranBulanan(?int $userId = null): array
    {
        $query = Setoran::whereYear('tanggal_setor', now()->year);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query
            ->selectRaw('MONTH(tanggal_setor) as bulan, SUM(total_saldo) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();
    }
}