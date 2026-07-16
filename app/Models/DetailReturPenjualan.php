<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReturPenjualan extends Model
{
    protected $table = 'detail_retur_penjualan';
    protected $fillable = ['id_retur_jual', 'id_barang', 'jumlah', 'alasan'];

    public function retur()
    {
        return $this->belongsTo(ReturPenjualan::class, 'id_retur_jual');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
