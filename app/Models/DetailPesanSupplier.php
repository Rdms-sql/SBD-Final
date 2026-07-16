<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanSupplier extends Model
{
    protected $table = 'detail_pesan_supplier';
    protected $fillable = ['id_pesan_supplier', 'id_barang', 'jumlah', 'harga_satuan', 'subtotal'];

    public function pemesananSupplier()
    {
        return $this->belongsTo(PemesananSupplier::class, 'id_pesan_supplier');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
