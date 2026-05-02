<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $isProduction;

    public function __construct()
    {
        $this->serverKey    = config('services.midtrans.server_key');
        $this->isProduction = config('services.midtrans.is_production');
    }

    protected function baseUrl()
    {
        return $this->isProduction
            ? 'https://app.midtrans.com'
            : 'https://api.sandbox.midtrans.com';
    }

    /**
     * 3.11 - Kirim pencairan dana ke Midtrans Iris
     */
    public function createDisbursement($bank, $account, $amount, $notes)
    {
        try {
            $payload = [
                'payouts' => [
                    [
                        'beneficiary_name'    => $notes,
                        'beneficiary_account' => $account,
                        'beneficiary_bank'    => strtolower($bank),
                        'beneficiary_email'   => 'nasabah@ecosaldo.test',
                        'amount'              => (string) $amount,
                        'notes'               => $notes,
                    ]
                ]
            ];

            Log::info('Midtrans Disbursement Request', $payload);

            $response = Http::withBasicAuth($this->serverKey, '')
                ->post($this->baseUrl() . '/iris/api/v1/payouts', $payload);

            $data = $response->json();

            Log::info('Midtrans Disbursement Response', [
                'status'   => $response->status(),
                'response' => $data,
            ]);

            if ($response->successful() && isset($data['payout_id'])) {
                return [
                    'success' => true,
                    'data'    => $data,
                ];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Pencairan gagal. Status: ' . $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Disbursement Error', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * 3.12 - Handle callback dari Midtrans
     */
    public function handleCallback($payload)
    {
        try {
            Log::info('Midtrans Callback Received', $payload);

            return [
                'success' => ($payload['status'] ?? '') === 'success',
                'data'    => $payload,
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}