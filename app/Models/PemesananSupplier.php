<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananSupplier extends Model
{
    protected $table = 'pemesanan_supplier';
    protected $fillable = ['id_supplier', 'tgl_pesan', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function detail()
    {
        return $this->hasMany(DetailPesanSupplier::class, 'id_pesan_supplier');
    }
}
