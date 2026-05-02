<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $nasabah = Role::create(['name' => 'nasabah']);

        $user = User::create([
            'name' => 'Admin EcoSaldo',
            'email' => 'admin@ecosaldo.test',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($admin);
    }
}