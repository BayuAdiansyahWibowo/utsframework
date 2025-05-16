<?php

// app/Models/Kendaraan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $fillable = ['nama_kendaraan', 'plat_nomor', 'jenis'];
}
