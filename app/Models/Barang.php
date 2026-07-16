<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['id_supplier', 'nama_barang', 'harga_jual', 'stok'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function detailPesanSupplier()
    {
        return $this->hasMany(DetailPesanSupplier::class, 'id_barang');
    }

    public function detailPesanKonsumen()
    {
        return $this->hasMany(DetailPesanKonsumen::class, 'id_barang');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_barang');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_barang');
    }
}
