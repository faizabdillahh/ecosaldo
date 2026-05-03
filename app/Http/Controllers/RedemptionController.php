<?php

namespace App\Http\Controllers;

use App\Models\Redemption;
use App\Models\Reward;
use App\Models\User;
use App\Notifications\RewardDitukar;
use App\Notifications\RewardSelesai;
use App\Notifications\RewardDibatalkan;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    public function catalog()
    {
        $rewards = Reward::where('stok', '>', 0)->get();
        $saldo = auth()->user()->balance;
        return view('redemption.catalog', compact('rewards', 'saldo'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $reward = Reward::findOrFail($request->reward_id);
        $saldo = $user->balance;

        if ($saldo < $reward->poin_dibutuhkan) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        if ($reward->stok < 1) {
            return back()->with('error', 'Stok habis.');
        }

        $redemption = Redemption::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'poin_dipakai' => $reward->poin_dibutuhkan,
            'status' => 'menunggu',
        ]);

        $reward->decrement('stok');

        $admin = User::role('admin')->first();
        if ($admin) {
            $admin->notify(new RewardDitukar($redemption));
        }

        return redirect()->route('redemption.history')->with('success', 'Reward berhasil ditukar. Menunggu diproses.');
    }

    public function history()
    {
        $redemptions = auth()->user()->redemptions()->with('reward')->latest()->paginate(10);
        return view('redemption.history', compact('redemptions'));
    }

    public function adminIndex()
    {
        $redemptions = Redemption::with(['user', 'reward'])->latest()->paginate(10);
        return view('redemption.admin', compact('redemptions'));
    }

    public function proses(Redemption $redemption)
    {
        $redemption->update(['status' => 'diproses']);
        return back()->with('success', 'Penukaran sedang diproses.');
    }

    public function selesaikan(Redemption $redemption)
    {
        $redemption->update(['status' => 'selesai']);
        $redemption->user->notify(new RewardSelesai($redemption));
        return back()->with('success', 'Penukaran selesai.');
    }

    public function tolak(Redemption $redemption)
    {
        $redemption->reward->increment('stok');
        $redemption->update(['status' => 'dibatalkan']);
        $redemption->user->notify(new RewardDibatalkan($redemption));
        return back()->with('success', 'Penukaran dibatalkan, stok dikembalikan.');
    }
}