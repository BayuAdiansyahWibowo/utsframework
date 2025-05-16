<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DriverMonitoringController extends Controller
{
    public function index(): View
    {
        return view('monitoring.index');
    }

    public function locations(): JsonResponse
    {
        $drivers = Driver::with('pengirimanAktif') // relasi aktif
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $data = $drivers->map(function ($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->nama,
                'latitude' => $driver->latitude,
                'longitude' => $driver->longitude,
                'awal' => [
                    'lat' => optional($driver->pengirimanAktif)->latitude_awal,
                    'lng' => optional($driver->pengirimanAktif)->longitude_awal,
                ],
                'tujuan' => [
                    'lat' => optional($driver->pengirimanAktif)->latitude_tujuan,
                    'lng' => optional($driver->pengirimanAktif)->longitude_tujuan,
                ]
            ];
        });

        return response()->json($data);
    }
}
