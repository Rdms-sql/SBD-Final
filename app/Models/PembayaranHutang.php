<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    protected $table = 'pembayaran_hutang';
    protected $fillable = ['id_hutang', 'tgl_bayar', 'jumlah_bayar'];

    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'id_hutang');
    }
}
