<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil supplier berdasarkan nama supaya tidak bergantung urutan ID
        $sinarSembako = Supplier::where('nama_supplier', 'PT Sinar Sembako Jaya')->first();
        $berasMakmur = Supplier::where('nama_supplier', 'CV Beras Makmur')->first();
        $gulaManis = Supplier::where('nama_supplier', 'UD Gula Manis')->first();
        $minyakNusantara = Supplier::where('nama_supplier', 'PT Minyak Nusantara')->first();
        $telurSegar = Supplier::where('nama_supplier', 'CV Telur Segar Abadi')->first();

        $barangs = [
            // Beras
            ['id_supplier' => $berasMakmur->id, 'nama_barang' => 'Beras Premium 5kg', 'harga_jual' => 68000, 'stok' => 50],
            ['id_supplier' => $berasMakmur->id, 'nama_barang' => 'Beras Medium 5kg', 'harga_jual' => 58000, 'stok' => 60],
            ['id_supplier' => $berasMakmur->id, 'nama_barang' => 'Beras Pandan Wangi 5kg', 'harga_jual' => 75000, 'stok' => 30],

            // Gula
            ['id_supplier' => $gulaManis->id, 'nama_barang' => 'Gula Pasir 1kg', 'harga_jual' => 15500, 'stok' => 100],
            ['id_supplier' => $gulaManis->id, 'nama_barang' => 'Gula Merah 1kg', 'harga_jual' => 18000, 'stok' => 45],
            ['id_supplier' => $gulaManis->id, 'nama_barang' => 'Gula Aren Kemasan 500gr', 'harga_jual' => 22000, 'stok' => 25],

            // Minyak
            ['id_supplier' => $minyakNusantara->id, 'nama_barang' => 'Minyak Goreng 1L', 'harga_jual' => 17500, 'stok' => 80],
            ['id_supplier' => $minyakNusantara->id, 'nama_barang' => 'Minyak Goreng 2L', 'harga_jual' => 33000, 'stok' => 40],
            ['id_supplier' => $minyakNusantara->id, 'nama_barang' => 'Minyak Goreng 5L', 'harga_jual' => 78000, 'stok' => 20],

            // Telur
            ['id_supplier' => $telurSegar->id, 'nama_barang' => 'Telur Ayam 1kg', 'harga_jual' => 28000, 'stok' => 70],
            ['id_supplier' => $telurSegar->id, 'nama_barang' => 'Telur Bebek 1kg', 'harga_jual' => 35000, 'stok' => 15],

            // Sembako Umum (PT Sinar Sembako Jaya)
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Tepung Terigu 1kg', 'harga_jual' => 13500, 'stok' => 90],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Garam Dapur 500gr', 'harga_jual' => 5000, 'stok' => 120],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Kecap Manis 600ml', 'harga_jual' => 21000, 'stok' => 55],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Saus Sambal 340ml', 'harga_jual' => 14500, 'stok' => 65],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Mie Instan Goreng (1 dus)', 'harga_jual' => 105000, 'stok' => 8],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Kopi Sachet (1 renceng)', 'harga_jual' => 16000, 'stok' => 40],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Teh Celup (1 kotak)', 'harga_jual' => 12000, 'stok' => 0],
            ['id_supplier' => $sinarSembako->id, 'nama_barang' => 'Susu Kental Manis 370gr', 'harga_jual' => 11500, 'stok' => 5],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
