<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
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
        $saldo = $user->setorans()->sum('total_saldo') - $user->withdrawals()->where('status', 'success')->sum('jumlah');

        $request->validate([
            'jumlah' => [
                'required',
                'integer',
                'min:10000',
                function ($attribute, $value, $fail) use ($saldo) {
                    if ($value > $saldo) {
                        $fail('Saldo tidak mencukupi.');
                    }
                },
            ],
        ]);

        $pending = $user->withdrawals()->where('status', 'pending')->exists();
        if ($pending) {
            return back()->with('error', 'Masih ada pengajuan yang belum diproses.');
        }

        Withdrawal::create([
            'user_id' => $user->id,
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'bank_tujuan' => $user->bank_name,
            'norek_tujuan' => $user->bank_account_number,
        ]);

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
        $withdrawal->update(['status' => 'verified']);
        return back()->with('success', 'Penarikan disetujui.');
    }
}
