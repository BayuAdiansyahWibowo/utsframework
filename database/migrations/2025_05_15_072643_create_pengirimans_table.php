<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('kendaraan_id');
            $table->unsignedBigInteger('driver_id');
            $table->integer('jumlah');

            // Koordinat rute pengiriman
            $table->decimal('latitude_awal', 10, 7)->nullable();
            $table->decimal('longitude_awal', 10, 7)->nullable();
            $table->decimal('latitude_tujuan', 10, 7)->nullable();
            $table->decimal('longitude_tujuan', 10, 7)->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};
