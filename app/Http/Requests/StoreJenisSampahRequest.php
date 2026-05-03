<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisSampahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'harga_per_kg' => ['required', 'integer', 'min:1'],
            'kategori' => ['nullable', 'string', 'max:50'],
        ];
    }
}