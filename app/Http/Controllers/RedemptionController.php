<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRedemptionRequest;
use App\Models\Redemption;
use App\Models\Reward;
use App\Models\User;
use App\Notifications\RewardDitukar;
use App\Notifications\RewardSelesai;
use App\Notifications\RewardDibatalkan;
use App\Services\RedemptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RedemptionController extends Controller
{
    public function __construct(
        protected RedemptionService $redemptionService
    ) {}

    /**
     * Katalog reward untuk nasabah.
     */
    public function catalog(): View
    {
        $rewards = Reward::where('stok', '>', 0)->get();
        $saldo = auth()->user()->balance;

        return view('redemption.catalog', compact('rewards', 'saldo'));
    }

    /**
     * Tukar reward.
     */
    public function store(StoreRedemptionRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $reward = Reward::findOrFail($request->validated()['reward_id']);

        $redemption = $this->redemptionService->redeem($user, $reward);

        $admin = User::role('admin')->first();
        if ($admin) {
            $admin->notify(new RewardDitukar($redemption));
        }

        return redirect()
            ->route('redemption.history')
            ->with('success', 'Reward berhasil ditukar. Menunggu diproses.');
    }

    /**
     * Riwayat penukaran nasabah.
     */
    public function history(): View
    {
        $redemptions = auth()->user()
            ->redemptions()
            ->with('reward')
            ->latest()
            ->paginate(10);

        return view('redemption.history', compact('redemptions'));
    }

    /**
     * Panel verifikasi penukaran - Admin.
     */
    public function adminIndex(): View
    {
        $redemptions = Redemption::with(['user', 'reward'])
            ->latest()
            ->paginate(10);

        return view('redemption.admin', compact('redemptions'));
    }

    /**
     * Proses penukaran.
     */
    public function proses(Redemption $redemption): RedirectResponse
    {
        $this->redemptionService->process($redemption);

        return back()->with('success', 'Penukaran sedang diproses.');
    }

    /**
     * Selesaikan penukaran.
     */
    public function selesaikan(Redemption $redemption): RedirectResponse
    {
        $this->redemptionService->complete($redemption);
        $redemption->user->notify(new RewardSelesai($redemption));

        return back()->with('success', 'Penukaran selesai.');
    }

    /**
     * Tolak penukaran.
     */
    public function tolak(Redemption $redemption): RedirectResponse
    {
        $this->redemptionService->cancel($redemption);
        $redemption->user->notify(new RewardDibatalkan($redemption));

        return back()->with('success', 'Penukaran dibatalkan, stok dikembalikan.');
    }
}