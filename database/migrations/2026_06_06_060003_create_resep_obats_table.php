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
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->id('id_resep');
            $table->unsignedBigInteger('id_daftar');
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_dokter');
            $table->text('jenis_obat');
            $table->unsignedInteger('id_proses')->nullable();
            $table->foreign('id_daftar')
                ->references('id_daftar')
                ->on('daftar');
            $table->foreign('id_pasien')
                ->references('id_pasien')
                ->on('pasien');
            $table->foreign('id_dokter')
                ->references('id_dokter')
                ->on('dokter');
            $table->foreign('id_proses')
                ->references('id_proses')
                ->on('proses_pasien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obats');
    }
};
