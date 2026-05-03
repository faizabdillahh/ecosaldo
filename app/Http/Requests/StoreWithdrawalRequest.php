<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('nasabah');
    }

    public function rules(): array
    {
        $saldo = auth()->user()->balance;

        return [
            'jumlah' => [
                'required',
                'integer',
                'min:10000',
                'max:' . $saldo,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'jumlah.max' => 'Saldo tidak mencukupi.',
            'jumlah.min' => 'Minimal penarikan Rp 10.000.',
        ];
    }
}