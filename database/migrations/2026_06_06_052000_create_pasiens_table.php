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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id('id_pasien');
            $table->char('nik', 16)->nullable();
            $table->string('nama_pasien', 50);
            $table->text('alamat_pasien');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('umur', 10);
            $table->string('no_hp', 15);
            $table->char('password', 6)->nullable();
            $table->unsignedBigInteger('id_akses');
            $table->char('no_identitas', 16)->nullable();
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
        Schema::dropIfExists('pasiens');
    }
};
