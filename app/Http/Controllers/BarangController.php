<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan daftar barang + pencarian
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $barangs = $query->get();

        return view('barang.index', [
            'barangs' => $barangs,
            'selectedJenis' => $request->jenis,
            'search' => $request->search,
        ]);
    }


    // Menyimpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|in:pangan,elektronik',
            'jumlah' => 'required|integer|min:0',
        ]);

        Barang::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $barangs = Barang::all(); // agar tetap tampil list
        return view('barang.index', compact('barang', 'barangs'));
    }

    // Memperbarui barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'jenis' => 'required|in:pangan,elektronik',
            'jumlah' => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->only(['nama', 'jenis', 'jumlah']));

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
