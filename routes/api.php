<?php

use App\Models\Withdrawal;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback', function (Request $request, MidtransService $midtrans) {
    $result = $midtrans->handleCallback($request->all());

    if ($result['success']) {
        $withdrawal = Withdrawal::where('midtrans_id', $result['data']['payout_id'] ?? null)->first();
        if ($withdrawal) {
            $withdrawal->update(['status' => 'success']);
        }
    }

    return response()->json(['status' => 'ok']);
});