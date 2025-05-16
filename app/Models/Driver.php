<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['nama', 'sim_path', 'kendaraan_id', 'alamat'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    use HasFactory;

    // app/Models/Driver.php
    public function pengirimanAktif()
    {
        return $this->hasOne(Pengiriman::class)->latest(); // atau gunakan kondisi aktif jika ada
    }

}
