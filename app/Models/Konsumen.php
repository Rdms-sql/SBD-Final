<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Konsumen extends Authenticatable
{
    protected $fillable = ['nama_konsumen', 'no_hp', 'alamat', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pemesananKonsumen()
    {
        return $this->hasMany(PemesananKonsumen::class, 'id_konsumen');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_konsumen');
    }
}
