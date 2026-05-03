<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RewardDibatalkan extends Notification
{
    use Queueable;

    public function __construct(
        protected Redemption $redemption
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Penukaran Dibatalkan',
            'message' => 'Penukaran ' . $this->redemption->reward->nama . ' dibatalkan. Stok dikembalikan.',
        ];
    }
}