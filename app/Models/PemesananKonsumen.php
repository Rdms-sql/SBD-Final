<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananKonsumen extends Model
{
    protected $table = 'pemesanan_konsumen';
    protected $fillable = ['id_konsumen', 'tgl_pesan', 'status', 'id_penjualan'];

    public function konsumen()
    {
        
        return $this->belongsTo(Konsumen::class, 'id_konsumen');
    }

    public function detail()
    {
        return $this->hasMany(DetailPesanKonsumen::class, 'id_pesan_konsumen');
    }
    
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }
}
