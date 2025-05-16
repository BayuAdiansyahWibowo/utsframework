<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('sim_path'); // untuk menyimpan nama file/foto SIM
            $table->unsignedBigInteger('kendaraan_id'); // relasi ke jenis kendaraan
            $table->string('alamat');
            $table->timestamps();

            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
