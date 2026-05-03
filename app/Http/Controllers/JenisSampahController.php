<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJenisSampahRequest;
use App\Http\Requests\UpdateJenisSampahRequest;
use App\Models\JenisSampah;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisSampahController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view('jenis-sampah.index', [
            'jenisSampahs' => JenisSampah::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('jenis-sampah.create');
    }

    public function store(StoreJenisSampahRequest $request): RedirectResponse
    {
        JenisSampah::create($request->validated());

        return redirect()
            ->route('jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil ditambahkan.');
    }

    public function edit(JenisSampah $jenisSampah): View
    {
        return view('jenis-sampah.edit', compact('jenisSampah'));
    }

    public function update(UpdateJenisSampahRequest $request, JenisSampah $jenisSampah): RedirectResponse
    {
        $jenisSampah->update($request->validated());

        return redirect()
            ->route('jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil diperbarui.');
    }

    public function destroy(JenisSampah $jenisSampah): RedirectResponse
    {
        $jenisSampah->delete();

        return redirect()
            ->route('jenis-sampah.index')
            ->with('success', 'Jenis sampah berhasil dihapus.');
    }
}