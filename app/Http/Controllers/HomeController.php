<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;

class HomeController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        return view('dashboard', compact('kendaraans'));
    }
}
