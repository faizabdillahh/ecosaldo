<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSetoranRequest;
use App\Models\JenisSampah;
use App\Models\Setoran;
use App\Models\User;
use App\Notifications\SetoranBerhasil;
use App\Services\SetoranService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SetoranController extends Controller
{
    public function __construct(
        protected SetoranService $setoranService
    ) {}

    /**
     * Form input setoran - Admin only.
     */
    public function create(): View
    {
        $nasabahs = User::role('nasabah')->latest('name')->get(['id', 'name', 'email']);
        $jenisSampahs = JenisSampah::orderBy('nama')->get(['id', 'nama', 'harga_per_kg']);

        return view('setoran.create', compact('nasabahs', 'jenisSampahs'));
    }

    /**
     * Simpan setoran baru.
     */
    public function store(StoreSetoranRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $jenis = JenisSampah::findOrFail($validated['jenis_sampah_id']);
        $admin = auth()->user();

        $setoran = $this->setoranService->create(
            nasabahId: (int) $validated['user_id'],
            adminId: $admin->id,
            jenisSampah: $jenis,
            beratKg: (float) $validated['berat_kg'],
        );

        $setoran->user->notify(new SetoranBerhasil($setoran));

        return redirect()
            ->route('setoran.create')
            ->with('success', 'Setoran berhasil dicatat. Saldo bertambah Rp ' . number_format($setoran->total_saldo));
    }

    /**
     * Riwayat setoran milik nasabah yang login.
     */
    public function index(): View
    {
        $setorans = Setoran::where('user_id', auth()->id())
            ->with('jenisSampah')
            ->latest()
            ->paginate(10);

        return view('setoran.index', compact('setorans'));
    }

    /**
     * Semua setoran - Admin only.
     */
    public function adminIndex(): View
    {
        $setorans = Setoran::with(['user', 'jenisSampah', 'admin'])
            ->latest()
            ->paginate(10);

        return view('setoran.admin', compact('setorans'));
    }
}