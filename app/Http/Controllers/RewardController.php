<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::all();
        return view('reward.index', compact('rewards'));
    }

    public function create()
    {
        return view('reward.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'poin_dibutuhkan' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'jenis' => 'required|in:fisik,digital',
        ]);

        Reward::create($request->all());

        return redirect()->route('reward.index')->with('success', 'Reward berhasil ditambahkan.');
    }

    public function edit(Reward $reward)
    {
        return view('reward.edit', compact('reward'));
    }

    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'poin_dibutuhkan' => 'required|integer|min:1',
            'stok' => 'required|integer|min:0',
            'jenis' => 'required|in:fisik,digital',
        ]);

        $reward->update($request->all());

        return redirect()->route('reward.index')->with('success', 'Reward berhasil diperbarui.');
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();
        return redirect()->route('reward.index')->with('success', 'Reward berhasil dihapus.');
    }
}