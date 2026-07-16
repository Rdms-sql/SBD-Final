<?php

namespace Database\Seeders;

use App\Models\Konsumen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KonsumenSeeder extends Seeder
{
    public function run(): void
    {
        Konsumen::create([
            'nama_konsumen' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
            'password' => Hash::make('password'),
        ]);

        Konsumen::create([
            'nama_konsumen' => 'Siti Aminah',
            'no_hp' => '081298765432',
            'alamat' => 'Jl. Sudirman No. 25, Jakarta',
            'password' => Hash::make('password'),
        ]);
    }
}
