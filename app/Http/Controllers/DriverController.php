<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Events\DriverLocationUpdated;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::with('kendaraan');

        // Filter berdasarkan nama driver
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan jenis kendaraan
        if ($request->filled('jenis_kendaraan')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis', $request->jenis_kendaraan);
            });
        }

        $drivers = $query->get();
        $jenisKendaraans = Kendaraan::distinct()->pluck('jenis');

        return view('drivers.index', compact('drivers', 'jenisKendaraans'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        return view('drivers.create', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'sim' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'alamat' => 'required',
        ]);

        $path = $request->file('sim')->store('sims', 'public');

        Driver::create([
            'nama' => $request->nama,
            'sim_path' => $path,
            'kendaraan_id' => $request->kendaraan_id,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('drivers.index')->with('success', 'Data driver berhasil disimpan.');
    }

    public function edit(Driver $driver)
    {
        $kendaraans = Kendaraan::all();
        return view('drivers.edit', compact('driver', 'kendaraans'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'nama' => 'required',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'alamat' => 'required',
            'sim' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama', 'kendaraan_id', 'alamat']);

        if ($request->hasFile('sim')) {
            // Hapus file lama jika ada
            if ($driver->sim_path && Storage::disk('public')->exists($driver->sim_path)) {
                Storage::disk('public')->delete($driver->sim_path);
            }

            $data['sim_path'] = $request->file('sim')->store('sims', 'public');
        }

        $driver->update($data);

        return redirect()->route('drivers.index')->with('success', 'Data driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->sim_path && Storage::disk('public')->exists($driver->sim_path)) {
            Storage::disk('public')->delete($driver->sim_path);
        }

        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Data driver berhasil dihapus.');
    }

    public function updateLocation(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        broadcast(new DriverLocationUpdated($driver))->toOthers();

        return response()->json(['status' => 'Location updated']);
    }
}
