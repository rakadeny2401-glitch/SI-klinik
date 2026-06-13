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
        Schema::create('dokter', function (Blueprint $table) {
            $table->id('id_dokter');
            $table->string('nama_dokter', 50);
            $table->string('no_hp_dokter', 15)->nullable();
            $table->text('alamat_dokter')->nullable();
            $table->date('tgl_lahir_dokter')->nullable();
            $table->time('waktu_kerja');
            $table->time('waktu_pulang')->nullable();
            $table->char('passworddok', 6)->nullable();
            $table->unsignedBigInteger('id_spesialis');
            $table->unsignedBigInteger('id_akses');
            $table->char('no_identitas', 16)->nullable();
            $table->foreign('id_spesialis')
                ->references('id_spesialis')
                ->on('spesialis');
            $table->foreign('id_akses')
                ->references('id_akses')
                ->on('hak_akses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
