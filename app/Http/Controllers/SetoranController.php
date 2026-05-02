<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\Setoran;
use App\Models\User;
use Illuminate\Http\Request;

class SetoranController extends Controller
{
    public function create()
    {
        $nasabahs = User::role('nasabah')->get();
        $jenisSampahs = JenisSampah::all();
        return view('setoran.create', compact('nasabahs', 'jenisSampahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat_kg' => 'required|numeric|min:0.1',
        ]);

        $jenis = JenisSampah::findOrFail($request->jenis_sampah_id);
        $total = $jenis->harga_per_kg * $request->berat_kg;

        Setoran::create([
            'user_id' => $request->user_id,
            'admin_id' => auth()->id(),
            'jenis_sampah_id' => $request->jenis_sampah_id,
            'berat_kg' => $request->berat_kg,
            'total_saldo' => $total,
            'tanggal_setor' => now(),
        ]);

        return redirect()->route('setoran.create')->with('success', 'Setoran berhasil dicatat.');
    }
    
    public function index()
    {
        $setorans = Setoran::where('user_id', auth()->id())
            ->with('jenisSampah')
            ->latest()
            ->paginate(10);

        return view('setoran.index', compact('setorans'));
    }

    public function adminIndex()
    {
        $setorans = Setoran::with(['user', 'jenisSampah', 'admin'])->latest()->paginate(10);
        return view('setoran.admin', compact('setorans'));
    }
}
