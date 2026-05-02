<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Iris;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$clientKey    = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = false;
    }

    public function createDisbursement($bank, $account, $amount, $notes)
    {
        // 3.11
    }

    public function handleCallback($payload)
    {
        // 3.12
    }
}