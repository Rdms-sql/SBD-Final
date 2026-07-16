<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $fillable = ['id_supplier', 'id_user', 'tgl_pembelian', 'status_bayar', 'total_beli'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detail()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian');
    }

    public function hutang()
    {
        return $this->hasOne(Hutang::class, 'id_pembelian');
    }

    public function retur()
    {
        return $this->hasOne(ReturPembelian::class, 'id_pembelian');
    }
}
