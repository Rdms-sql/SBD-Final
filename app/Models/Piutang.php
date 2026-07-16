<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $table = 'piutang';
    protected $fillable = ['id_penjualan', 'sisa_piutang', 'jatuh_tempo'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function penerimaan()
    {
        return $this->hasMany(PenerimaanPiutang::class, 'id_piutang');
    }
}
