<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    // Tambahkan ini untuk menetapkan nama tabel yang benar
    protected $table = 'pengirimans';

    protected $fillable = [
        'barang_id',
        'kendaraan_id',
        'driver_id',
        'jumlah',
        'latitude_awal',
        'longitude_awal',
        'latitude_tujuan',
        'longitude_tujuan',
    ];

    public function barang() { return $this->belongsTo(Barang::class); }
    public function kendaraan() { return $this->belongsTo(Kendaraan::class); }
    public function driver() { return $this->belongsTo(Driver::class); }
}
