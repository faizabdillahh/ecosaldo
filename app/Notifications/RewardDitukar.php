<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RewardDitukar extends Notification
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
            'title' => 'Reward Ditukar',
            'message' => $this->redemption->user->name . ' menukar ' . $this->redemption->reward->nama,
        ];
    }
}