<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\User;
use App\Models\Withdrawal;
use App\Notifications\WithdrawalDiajukan;
use App\Notifications\WithdrawalDisetujui;
use App\Services\WithdrawalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    public function __construct(
        protected WithdrawalService $withdrawalService
    ) {}

    /**
     * Form pengajuan tarik saldo.
     */
    public function create(): View
    {
        $user = auth()->user();
        return view('withdrawal.create', compact('user'));
    }

    /**
     * Simpan pengajuan tarik saldo baru.
     */
    public function store(StoreWithdrawalRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

        try {
            $withdrawal = $this->withdrawalService->create(
                user: $user,
                jumlah: (int) $validated['jumlah'],
            );

            $admin = User::role('admin')->first();
            if ($admin) {
                $admin->notify(new WithdrawalDiajukan($withdrawal));
            }

            return redirect()
                ->route('withdrawal.index')
                ->with('success', 'Pengajuan tarik saldo berhasil.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Riwayat penarikan nasabah login.
     */
    public function index(): View
    {
        $withdrawals = auth()->user()
            ->withdrawals()
            ->latest()
            ->paginate(10);

        return view('withdrawal.index', compact('withdrawals'));
    }

    /**
     * Panel verifikasi penarikan - Admin only.
     */
    public function adminIndex(Request $request): View
    {
        $withdrawals = $this->withdrawalService->getFiltered($request->only(['user_id', 'status', 'month']));
        $pending = Withdrawal::where('status', 'pending')->count();
        $nasabahs = User::role('nasabah')->latest('name')->get(['id', 'name']);

        return view('withdrawal.admin', compact('withdrawals', 'pending', 'nasabahs'));
    }

    /**
     * Verifikasi penarikan - Admin only.
     */
    public function verify(Withdrawal $withdrawal): RedirectResponse
    {
        $this->withdrawalService->verify($withdrawal);

        $withdrawal->user->notify(new WithdrawalDisetujui($withdrawal));

        return back()->with('success', 'Penarikan disetujui. Saldo berhasil diproses.');
    }
}