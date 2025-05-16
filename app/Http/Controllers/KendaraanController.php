<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kendaraan::query();

        // Filter berdasarkan nama
        if ($request->filled('nama')) {
            $query->where('nama_kendaraan', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $kendaraans = $query->get();

        return view('kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kendaraan' => 'required',
            'plat_nomor' => 'required|unique:kendaraans',
            'jenis' => 'required',
        ]);

        Kendaraan::create($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'nama_kendaraan' => 'required',
            'plat_nomor' => 'required|unique:kendaraans,plat_nomor,' . $kendaraan->id,
            'jenis' => 'required',
        ]);

        $kendaraan->update($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan dihapus.');
    }
}
