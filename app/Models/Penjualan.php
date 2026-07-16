<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $fillable = ['id_konsumen', 'id_user', 'tgl_penjualan', 'status_bayar', 'total_jual'];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detail()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }

    public function piutang()
    {
        return $this->hasOne(Piutang::class, 'id_penjualan');
    }

    public function retur()
    {
        return $this->hasOne(ReturPenjualan::class, 'id_penjualan');
    }
}
