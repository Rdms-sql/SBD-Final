<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanPiutang extends Model
{
    protected $table = 'penerimaan_piutang';
    protected $fillable = ['id_piutang', 'tgl_terima', 'jumlah_terima'];

    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'id_piutang');
    }
}
