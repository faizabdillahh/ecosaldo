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
    public function getRingkasan(string $dari, string $sampai): array
    {
        return [
            'dari' => $dari,
            'sampai' => $sampai,
            'totalNasabah' => User::role('nasabah')->count(),
            'totalSetoran' => Setoran::whereBetween('tanggal_setor', [$dari, $sampai])->count(),
            'totalBerat' => Setoran::whereBetween('tanggal_setor', [$dari, $sampai])->sum('berat_kg'),
            'totalSaldoDikeluarkan' => Setoran::whereBetween('tanggal_setor', [$dari, $sampai])->sum('total_saldo'),
            'totalPenarikan' => Withdrawal::where('status', WithdrawalStatus::SUCCESS)
                ->whereBetween('created_at', [$dari, $sampai])
                ->sum('jumlah'),
            'pendingWithdrawal' => Withdrawal::where('status', WithdrawalStatus::PENDING)->count(),
            'totalRewardDitukar' => Redemption::whereBetween('created_at', [$dari, $sampai])->count(),
            'ringkasanJenis' => JenisSampah::withSum(
                ['setorans' => fn($q) => $q->whereBetween('tanggal_setor', [$dari, $sampai])], 'berat_kg'
            )->withSum(
                ['setorans' => fn($q) => $q->whereBetween('tanggal_setor', [$dari, $sampai])], 'total_saldo'
            )->get(),
            'rewardPopuler' => Reward::withCount(
                ['redemptions' => fn($q) => $q->whereBetween('created_at', [$dari, $sampai])]
            )->orderByDesc('redemptions_count')->take(5)->get(),
        ];
    }

    public function exportSetoran(string $dari, string $sampai): BinaryFileResponse
    {
        $setorans = Setoran::with(['user', 'jenisSampah'])
            ->whereBetween('tanggal_setor', [$dari, $sampai])
            ->latest()
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Tanggal', 'Nasabah', 'Jenis Sampah', 'Berat (kg)', 'Saldo'];
        $sheet->fromArray($headers, null, 'A1');

        $headerStyle = $sheet->getStyle('A1:E1');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF90EE90');

        $row = 2;
        foreach ($setorans as $s) {
            $sheet->setCellValue('A' . $row, $s->tanggal_setor);
            $sheet->setCellValue('B' . $row, $s->user->name);
            $sheet->setCellValue('C' . $row, $s->jenisSampah->nama);
            $sheet->setCellValue('D' . $row, $s->berat_kg);
            $sheet->setCellValue('E' . $row, $s->total_saldo);
            $row++;
        }

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle('A1:E' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return $this->downloadXlsx($spreadsheet, "laporan-setoran-{$dari}-to-{$sampai}.xlsx");
    }

    public function exportWithdrawals(string $dari, string $sampai): BinaryFileResponse
    {
        $withdrawals = Withdrawal::with('user')
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Tanggal', 'Nasabah', 'Jumlah', 'Bank', 'Rekening', 'Status'];
        $sheet->fromArray($headers, null, 'A1');

        $headerStyle = $sheet->getStyle('A1:F1');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFD700');

        $row = 2;
        foreach ($withdrawals as $w) {
            $sheet->setCellValue('A' . $row, $w->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $w->user->name);
            $sheet->setCellValue('C' . $row, $w->jumlah);
            $sheet->setCellValue('D' . $row, $w->bank_tujuan);
            $sheet->setCellValue('E' . $row, $w->norek_tujuan);
            $sheet->setCellValue('F' . $row, ucfirst($w->status));
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle('A1:F' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return $this->downloadXlsx($spreadsheet, "laporan-penarikan-{$dari}-to-{$sampai}.xlsx");
    }

    public function exportRedemptions(string $dari, string $sampai): BinaryFileResponse
    {
        $redemptions = Redemption::with(['user', 'reward'])
            ->whereBetween('created_at', [$dari, $sampai])
            ->latest()
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['Tanggal', 'Nasabah', 'Reward', 'Poin', 'Jenis', 'Status'];
        $sheet->fromArray($headers, null, 'A1');

        $headerStyle = $sheet->getStyle('A1:F1');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDA0DD');

        $row = 2;
        foreach ($redemptions as $r) {
            $sheet->setCellValue('A' . $row, $r->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $row, $r->user->name);
            $sheet->setCellValue('C' . $row, $r->reward->nama);
            $sheet->setCellValue('D' . $row, $r->poin_dipakai);
            $sheet->setCellValue('E' . $row, ucfirst($r->reward->jenis));
            $sheet->setCellValue('F' . $row, ucfirst($r->status));
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle('A1:F' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return $this->downloadXlsx($spreadsheet, "laporan-reward-{$dari}-to-{$sampai}.xlsx");
    }

    /**
     * Simpan spreadsheet ke file temporary & return download response.
     */
    private function downloadXlsx(Spreadsheet $spreadsheet, string $filename): BinaryFileResponse
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'ecosaldo') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend();
    }
}