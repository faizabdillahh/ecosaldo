<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetoranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'jenis_sampah_id' => ['required', 'exists:jenis_sampahs,id'],
            'berat_kg' => ['required', 'numeric', 'min:0.1'],
        ];
    }
}