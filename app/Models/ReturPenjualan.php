<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturPenjualan extends Model
{
    protected $table = 'retur_penjualan';
    protected $fillable = ['id_penjualan', 'tgl_retur'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function detail()
    {
        return $this->hasMany(DetailReturPenjualan::class, 'id_retur_jual');
    }
}
