<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kendaraan;
use App\Models\Driver;
use App\Models\Pengiriman; // Pastikan kamu punya model ini

class TugasPengirimanController extends Controller
{
    public function create()
    {
        $barangs = Barang::all();
        $kendaraans = Kendaraan::all();
        $drivers = Driver::with('kendaraan')->get();

        return view('tugas.create', compact('barangs', 'kendaraans', 'drivers'));
    }

    public function store(Request $request)
    {
        // Validasi input termasuk koordinat awal dan tujuan
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver_id' => 'required|exists:drivers,id',
            'latitude_awal' => 'required|numeric',
            'longitude_awal' => 'required|numeric',
            'latitude_tujuan' => 'required|numeric',
            'longitude_tujuan' => 'required|numeric',
        ]);

        // Simpan ke tabel pengiriman (pastikan kamu punya tabel dan modelnya)
        Pengiriman::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'kendaraan_id' => $request->kendaraan_id,
            'driver_id' => $request->driver_id,
            'latitude_awal' => $request->latitude_awal,
            'longitude_awal' => $request->longitude_awal,
            'latitude_tujuan' => $request->latitude_tujuan,
            'longitude_tujuan' => $request->longitude_tujuan,
        ]);

        // Update posisi awal driver untuk monitoring
        Driver::where('id', $request->driver_id)->update([
            'latitude' => $request->latitude_awal,
            'longitude' => $request->longitude_awal,
        ]);

        return back()->with('success', 'Tugas pengiriman berhasil disimpan dan posisi driver diupdate.');
    }
}
