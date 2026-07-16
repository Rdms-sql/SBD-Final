<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    protected $table = 'retur_pembelian';
    protected $fillable = ['id_pembelian', 'tgl_retur'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function detail()
    {
        return $this->hasMany(DetailReturPembelian::class, 'id_retur_beli');
    }
}
