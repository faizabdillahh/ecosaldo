<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private string $serverKey;
    private bool $isProduction;

    public function __construct()
    {
        $this->serverKey    = config('services.midtrans.server_key');
        $this->isProduction = config('services.midtrans.is_production');
    }

    /**
     * Kirim pencairan dana ke Midtrans Iris.
     */
    public function createDisbursement(
        string $bank,
        string $account,
        int $amount,
        string $notes
    ): array {
        try {
            $payload = [
                'payouts' => [[
                    'beneficiary_name'    => $notes,
                    'beneficiary_account' => $account,
                    'beneficiary_bank'    => strtolower($bank),
                    'beneficiary_email'   => 'nasabah@ecosaldo.test',
                    'amount'              => (string) $amount,
                    'notes'               => $notes,
                ]],
            ];

            Log::info('Midtrans Disbursement Request', $payload);

            $response = Http::withBasicAuth($this->serverKey, '')
                ->post($this->baseUrl() . '/iris/api/v1/payouts', $payload);

            $data = $response->json();

            $this->logResponse($response, $data);

            if ($response->successful() && isset($data['payout_id'])) {
                return ['success' => true, 'data' => $data];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Pencairan gagal. Status: ' . $response->status(),
            ];
        } catch (\Throwable $e) {
            Log::error('Midtrans Disbursement Error', ['error' => $e->getMessage()]);

            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }

    /**
     * Handle callback dari Midtrans.
     */
    public function handleCallback(array $payload): array
    {
        try {
            Log::info('Midtrans Callback Received', $payload);

            return [
                'success' => ($payload['status'] ?? '') === 'success',
                'data'    => $payload,
            ];
        } catch (\Throwable $e) {
            Log::error('Midtrans Callback Error', ['error' => $e->getMessage()]);

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Base URL Midtrans API.
     */
    private function baseUrl(): string
    {
        return $this->isProduction
            ? 'https://app.midtrans.com'
            : 'https://api.sandbox.midtrans.com';
    }

    /**
     * Log response dari Midtrans.
     */
    private function logResponse(Response $response, ?array $data): void
    {
        Log::info('Midtrans Disbursement Response', [
            'status'   => $response->status(),
            'response' => $data,
        ]);
    }
}