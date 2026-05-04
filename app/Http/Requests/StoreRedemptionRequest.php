<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRedemptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('nasabah');
    }

    public function rules(): array
    {
        return [
            'reward_id' => ['required', 'exists:rewards,id'],
            'quantity'  => ['required', 'integer', 'min:1'],
        ];
    }
}