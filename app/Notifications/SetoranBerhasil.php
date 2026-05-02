<?php

namespace App\Notifications;

use App\Models\Setoran;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SetoranBerhasil extends Notification
{
    use Queueable;

    protected $setoran;

    public function __construct(Setoran $setoran)
    {
        $this->setoran = $setoran;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Setoran Berhasil',
            'message' => 'Setoran ' . $this->setoran->jenisSampah->nama . ' sebesar ' . $this->setoran->berat_kg . ' kg berhasil.',
            'saldo' => $this->setoran->total_saldo,
        ];
    }
}