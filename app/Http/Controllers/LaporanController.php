<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $laporanService
    ) {}

    public function index(Request $request): View
    {
        $dari = $request->dari ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        return view('laporan.index', $this->laporanService->getRingkasan($dari, $sampai));
    }

    public function export(Request $request): BinaryFileResponse
    {
        $dari = $request->dari ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        return $this->laporanService->exportSetoran($dari, $sampai);
    }

    public function exportWithdrawals(Request $request): BinaryFileResponse
    {
        $dari = $request->dari ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        return $this->laporanService->exportWithdrawals($dari, $sampai);
    }

    public function exportRedemptions(Request $request): BinaryFileResponse
    {
        $dari = $request->dari ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        return $this->laporanService->exportRedemptions($dari, $sampai);
    }
}