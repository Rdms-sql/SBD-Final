<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'nama_supplier' => 'PT Sinar Sembako Jaya',
                'no_hp' => '081111222333',
                'alamat' => 'Jl. Raya Industri No. 12, Bandung',
            ],
            [
                'nama_supplier' => 'CV Beras Makmur',
                'no_hp' => '081222333444',
                'alamat' => 'Jl. Cihampelas No. 45, Bandung',
            ],
            [
                'nama_supplier' => 'UD Gula Manis',
                'no_hp' => '081333444555',
                'alamat' => 'Jl. Soekarno Hatta No. 88, Bandung',
            ],
            [
                'nama_supplier' => 'PT Minyak Nusantara',
                'no_hp' => '081444555666',
                'alamat' => 'Jl. Pasteur No. 21, Bandung',
            ],
            [
                'nama_supplier' => 'CV Telur Segar Abadi',
                'no_hp' => '081555666777',
                'alamat' => 'Jl. Dago No. 5, Bandung',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
