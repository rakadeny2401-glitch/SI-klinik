<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proses_pasien', function (Blueprint $table) {
            $table->increments('id_proses');
            $table->unsignedBigInteger('id_daftar');
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_dokter');
            $table->unsignedBigInteger('id_admin');
            $table->unsignedBigInteger('id_spesialis');
            $table->string('no_antrian', 10);
            $table->dateTime('tgl_pemeriksaan');
            $table->foreign('id_daftar')
                ->references('id_daftar')
                ->on('daftar');
            $table->foreign('id_pasien')
                ->references('id_pasien')
                ->on('pasien');
            $table->foreign('id_dokter')
                ->references('id_dokter')
                ->on('dokter');
            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admin');
            $table->foreign('id_spesialis')
                ->references('id_spesialis')
                ->on('spesialis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses_pasiens');
    }
};
