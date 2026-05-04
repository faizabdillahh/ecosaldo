<?php

namespace App\Services;

use App\Enums\WithdrawalStatus;
use App\Models\JenisSampah;
use App\Models\Redemption;
use App\Models\Reward;
use App\Models\Setoran;
use App\Models\User;
use App\Models\Withdrawal;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LaporanService
{
    private const FORMAT_RP = 'Rp #,##0';
    private const HEADER_COLOR_SETORAN = 'FF90EE90';
    private const HEADER_COLOR_PENARIKAN = 'FFFFD700';
    private const HEADER_COLOR_REWARD = 'FFDDA0DD';

    /**
     * Data ringkasan untuk halaman laporan.
     */
    public function getRingkasan(string $dari, string $sampai): array
    {
        return [
            'dari'               => $dari,
            'sampai'             => $sampai,
            'totalNasabah'       => User::role('nasabah')->count(),
            'totalSetoran'       => Setoran::whereBetween('tanggal_setor', [$dari, $sampai])->count(),
            'totalBerat'         => Setoran::whereBetween('tanggal_setor', [$dari, $sampai])->sum('berat_kg'),
            'totalSaldoDikeluarkan' => Setoran::whereBetween('tanggal_setor', [$dari, $sampai])->sum('total_saldo'),
            'totalPenarikan'     => Withdrawal::where('status', WithdrawalStatus::SUCCESS)
                ->whereBetween('created_at', [$dari, $sampai])->sum('jumlah'),
            'pendingWithdrawal'  => Withdrawal::where('status', WithdrawalStatus::PENDING)->count(),
            'totalRewardDitukar' => Redemption::whereBetween('created_at', [$dari, $sampai])->count(),
            'ringkasanJenis'     => JenisSampah::withSum(
                ['setorans' => fn($q) => $q->whereBetween('tanggal_setor', [$dari, $sampai])],
                'berat_kg'
            )->withSum(
                ['setorans' => fn($q) => $q->whereBetween('tanggal_setor', [$dari, $sampai])],
                'total_saldo'
            )->get(),
            'rewardPopuler'      => Reward::withCount(
                ['redemptions' => fn($q) => $q->whereBetween('created_at', [$dari, $sampai])]
            )->orderByDesc('redemptions_count')->take(5)->get(),
        ];
    }

    /**
     * Export laporan setoran.
     */
    public function exportSetoran(string $dari, string $sampai): BinaryFileResponse
    {
        $data = Setoran::with(['user', 'jenisSampah'])
            ->whereBetween('tanggal_setor', [$dari, $sampai])
            ->latest()
            ->get();

        $headers = ['Tanggal & Waktu', 'Nasabah', 'Jenis Sampah', 'Berat (kg)', 'Saldo'];

        $rows = $data->map(fn(Setoran $s) => [
            $s->created_at->format('d/m/Y H:i'),
            $s->user->name,
            $s->jenisSampah->nama,
            $s->berat_kg,
            $this->formatRupiah($s->total_saldo),
        ])->toArray();

        return $this->buildExcel(
            $headers,
            $rows,
            self::HEADER_COLOR_SETORAN,
            "laporan-setoran-{$dari}-to-{$sampai}"
        );
    }

    /**
     * Export laporan penarikan.
     */
    public function exportWithdrawals(string $dari, string $sampai): BinaryFileResponse
    {
        $data = Withdrawal::with('user')
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $headers = ['Tanggal & Waktu', 'Nasabah', 'Jumlah', 'Bank', 'Rekening', 'Status'];

        $rows = $data->map(fn(Withdrawal $w) => [
            $w->created_at->format('d/m/Y H:i'),
            $w->user->name,
            $this->formatRupiah($w->jumlah),
            $w->bank_tujuan,
            $w->norek_tujuan,
            $w->status->label(),
        ])->toArray();

        return $this->buildExcel(
            $headers,
            $rows,
            self::HEADER_COLOR_PENARIKAN,
            "laporan-penarikan-{$dari}-to-{$sampai}"
        );
    }

    /**
     * Export laporan penukaran reward.
     */
    public function exportRedemptions(string $dari, string $sampai): BinaryFileResponse
    {
        $data = Redemption::with(['user', 'reward'])
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $headers = ['Tanggal & Waktu', 'Nasabah', 'Reward', 'Poin', 'Jenis', 'Status'];

        $rows = $data->map(fn(Redemption $r) => [
            $r->created_at->format('d/m/Y H:i'),
            $r->user->name,
            $r->reward->nama,
            $this->formatRupiah($r->poin_dipakai),
            $r->reward->jenis->label(),
            $r->status->label(),
        ])->toArray();

        return $this->buildExcel(
            $headers,
            $rows,
            self::HEADER_COLOR_REWARD,
            "laporan-reward-{$dari}-to-{$sampai}"
        );
    }

    /**
     * Build Excel spreadsheet dari headers & rows.
     */
    private function buildExcel(array $headers, array $rows, string $headerColor, string $filePrefix): BinaryFileResponse
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $lastCol = chr(64 + count($headers)); // A, B, C, ...
        $range = "A1:{$lastCol}1";

        $sheet->fromArray($headers, null, 'A1');
        $sheet->fromArray($rows, null, 'A2');

        // Header styling
        $headerStyle = $sheet->getStyle($range);
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($headerColor);

        // Auto width
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $lastRow = count($rows) + 1;
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $filename = "{$filePrefix}-" . now()->format('His') . '.xlsx';

        return $this->downloadXlsx($spreadsheet, $filename);
    }

    /**
     * Simpan spreadsheet ke file temporary & return download response.
     */
    private function downloadXlsx(Spreadsheet $spreadsheet, string $filename): BinaryFileResponse
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'ecosaldo') . '.xlsx';
        (new Xlsx($spreadsheet))->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend();
    }

    /**
     * Format angka ke Rupiah string.
     */
    private function formatRupiah(int|float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
