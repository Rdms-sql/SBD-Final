<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $table = 'hutang';
    protected $fillable = ['id_pembelian', 'sisa_hutang', 'jatuh_tempo'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranHutang::class, 'id_hutang');
    }
}
