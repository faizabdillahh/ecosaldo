<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WithdrawalDiajukan extends Notification
{
    use Queueable;

    protected $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Penarikan Diajukan',
            'message' => 'Pengajuan tarik saldo Rp ' . number_format($this->withdrawal->jumlah) . ' sedang menunggu verifikasi.',
        ];
    }
}