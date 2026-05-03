<?php

use App\Enums\WithdrawalStatus;
use App\Models\Withdrawal;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback', function (Request $request, MidtransService $midtrans) {
    Log::info('Midtrans Callback', $request->all());

    $result = $midtrans->handleCallback($request->all());

    if ($result['success']) {
        $payoutId = $result['data']['payout_id'] ?? null;

        if ($payoutId) {
            Withdrawal::where('midtrans_id', $payoutId)
                ->update(['status' => WithdrawalStatus::SUCCESS]);
        }
    }

    return response()->json(['status' => 'ok']);
})->middleware('throttle:midtrans-callback');