<?php

namespace App\Http\Requests;

use App\Enums\RewardType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRewardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        $types = implode(',', array_map(fn($t) => $t->value, RewardType::cases()));

        return [
            'nama' => ['required', 'string', 'max:100'],
            'poin_dibutuhkan' => ['required', 'integer', 'min:1'],
            'stok' => ['required', 'integer', 'min:0'],
            'jenis' => ['required', 'in:' . $types],
        ];
    }
}