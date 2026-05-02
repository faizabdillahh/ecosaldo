<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalDiajukan;
use App\Notifications\WithdrawalDisetujui;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        return view('withdrawal.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $saldo = $user->balance;

        $request->validate([
            'jumlah' => [
                'required',
                'integer',
                'min:10000',
                'max:' . $saldo,
            ],
        ], [
            'jumlah.max' => 'Saldo tidak mencukupi. Saldo Anda: Rp ' . number_format($saldo),
            'jumlah.min' => 'Minimal penarikan Rp 10.000.',
        ]);

        $pending = $user->withdrawals()->where('status', 'pending')->exists();
        if ($pending) {
            return back()->with('error', 'Masih ada pengajuan yang belum diproses.');
        }

        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'bank_tujuan' => $user->bank_name,
            'norek_tujuan' => $user->bank_account_number,
        ]);

        $admin = User::role('admin')->first();
        if ($admin) {
            $admin->notify(new WithdrawalDiajukan($withdrawal));
        }

        return redirect()->route('withdrawal.index')->with('success', 'Pengajuan tarik saldo berhasil.');
    }

    public function index()
    {
        $withdrawals = auth()->user()->withdrawals()->latest()->paginate(10);
        return view('withdrawal.index', compact('withdrawals'));
    }

    public function adminIndex()
    {
        $withdrawals = Withdrawal::with('user')->latest()->paginate(10);
        return view('withdrawal.admin', compact('withdrawals'));
    }

    public function verify(Withdrawal $withdrawal)
    {
        $withdrawal->update([
            'status' => 'success',
            'midtrans_id' => 'manual-' . uniqid(),
        ]);

        $withdrawal->user->notify(new WithdrawalDisetujui($withdrawal));

        return back()->with('success', 'Penarikan disetujui. Saldo berhasil diproses.');
    }
}