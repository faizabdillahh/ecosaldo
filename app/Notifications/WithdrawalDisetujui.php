<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WithdrawalDisetujui extends Notification
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
            'title' => 'Penarikan Disetujui',
            'message' => 'Tarik saldo Rp ' . number_format($this->withdrawal->jumlah) . ' telah disetujui.',
        ];
    }
}