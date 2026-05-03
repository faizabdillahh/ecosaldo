<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RewardSelesai extends Notification
{
    use Queueable;

    protected $redemption;

    public function __construct(Redemption $redemption)
    {
        $this->redemption = $redemption;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Penukaran Selesai',
            'message' => 'Penukaran ' . $this->redemption->reward->nama . ' telah selesai.',
        ];
    }
}