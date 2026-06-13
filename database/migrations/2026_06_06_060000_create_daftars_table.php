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
        Schema::create('daftar', function (Blueprint $table) {
            $table->id('id_daftar');
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_spesialis');
            $table->unsignedBigInteger('id_dokter')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->string('nama_pasien', 50);
            $table->text('alamat_pasien');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('umur', 10);
            $table->char('nik', 16)->nullable();
            $table->text('keluhan')->nullable();
            $table->dateTime('waktu_daftar');
            $table->foreign('id_pasien')
                ->references('id_pasien')
                ->on('pasien');
            $table->foreign('id_spesialis')
                ->references('id_spesialis')
                ->on('spesialis');
            $table->foreign('id_dokter')
                ->references('id_dokter')
                ->on('dokter');
            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftars');
    }
};
