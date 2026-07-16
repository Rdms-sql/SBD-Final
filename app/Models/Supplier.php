<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama_supplier', 'no_hp', 'alamat'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_supplier');
    }

    public function pemesananSupplier()
    {
        return $this->hasMany(PemesananSupplier::class, 'id_supplier');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier');
    }
}
