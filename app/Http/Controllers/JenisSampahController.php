<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index()
    {
        $jenisSampahs = JenisSampah::all();
        return view('jenis-sampah.index', compact('jenisSampahs'));
    }

    public function create()
    {
        return view('jenis-sampah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'harga_per_kg' => 'required|integer|min:1',
            'kategori' => 'nullable|string|max:50',
        ]);

        JenisSampah::create($request->all());

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function edit(JenisSampah $jenisSampah)
    {
        return view('jenis-sampah.edit', compact('jenisSampah'));
    }

    public function update(Request $request, JenisSampah $jenisSampah)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'harga_per_kg' => 'required|integer|min:1',
            'kategori' => 'nullable|string|max:50',
        ]);

        $jenisSampah->update($request->all());

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    public function destroy(JenisSampah $jenisSampah)
    {
        $jenisSampah->delete();

        return redirect()->route('jenis-sampah.index')->with('success', 'Jenis sampah berhasil dihapus.');
    }
}