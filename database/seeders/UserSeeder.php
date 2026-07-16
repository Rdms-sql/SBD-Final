<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@grosir.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nama_lengkap' => 'Kasir Satu',
            'username' => 'kasir1',
            'email' => 'kasir@grosir.com',
            'role' => 'kasir',
            'password' => Hash::make('password'),
        ]);
    }
}
