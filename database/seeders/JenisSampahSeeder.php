<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use Illuminate\Database\Seeder;

class JenisSampahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Kardus',             'harga_per_kg' => 1260, 'kategori' => 'Kertas'],
            ['nama' => 'Botol Plastik PET',   'harga_per_kg' => 50,   'kategori' => 'Plastik'],
            ['nama' => 'Plastik Campur',      'harga_per_kg' => 50,   'kategori' => 'Plastik'],
            ['nama' => 'Kaleng Aluminium',    'harga_per_kg' => 9000, 'kategori' => 'Logam'],
            ['nama' => 'Besi Tua',            'harga_per_kg' => 2160, 'kategori' => 'Logam'],
            ['nama' => 'Botol Kaca',          'harga_per_kg' => 120,  'kategori' => 'Kaca'],
            ['nama' => 'Kertas Putih',        'harga_per_kg' => 720,  'kategori' => 'Kertas'],
            ['nama' => 'Minyak Jelantah',     'harga_per_kg' => 3600, 'kategori' => 'Minyak'],
        ];

        foreach ($data as $item) {
            JenisSampah::create($item);
        }
    }
}