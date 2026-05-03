<?php

namespace Database\Seeders;

use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Pulsa 10.000',       'poin_dibutuhkan' => 11000, 'stok' => 10, 'jenis' => 'digital'],
            ['nama' => 'Minyak Goreng 1L',    'poin_dibutuhkan' => 20000, 'stok' => 5,  'jenis' => 'fisik'],
            ['nama' => 'Beras 5kg',           'poin_dibutuhkan' => 75000, 'stok' => 3,  'jenis' => 'fisik'],
            ['nama' => 'Token Listrik 20.000', 'poin_dibutuhkan' => 21000, 'stok' => 10, 'jenis' => 'digital'],
            ['nama' => 'Sabun Cuci Piring',   'poin_dibutuhkan' => 8000,  'stok' => 10, 'jenis' => 'fisik'],
        ];

        foreach ($data as $item) {
            Reward::create($item);
        }
    }
}