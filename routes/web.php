<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverMonitoringController;
use App\Http\Controllers\TugasPengirimanController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\Kendaraan;

Route::get('/', function () {
    return view('welcome');
});

// 🔐 Auth Routes (Custom Login/Register)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Forgot Password Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset Password Routes
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// 🛡️ Routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Kendaraan
    Route::get('/kendaraan', function () {
        $kendaraans = Kendaraan::all();
        return view('kendaraan.index', compact('kendaraans'));
    })->name('kendaraan.index');
    Route::resource('kendaraan', KendaraanController::class)->except(['show']);

    // Barang
    Route::resource('barang', BarangController::class)->except(['show']);

    // Driver
    Route::resource('drivers', DriverController::class);

    // Tugas Pengiriman
    Route::get('/tugas-pengiriman', [TugasPengirimanController::class, 'create'])->name('tugas.create');
    Route::post('/tugas-pengiriman', [TugasPengirimanController::class, 'store'])->name('tugas.store');

    // Monitoring
    Route::get('/monitoring', [DriverMonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/api/monitoring/locations', [DriverMonitoringController::class, 'locations'])->name('api.monitoring.locations');
});
