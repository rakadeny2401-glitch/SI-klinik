<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nama_admin', 50);
            $table->time('waktu_jaga');
            $table->char('passwordadmin', 6)->nullable();
            $table->unsignedBigInteger('id_akses');
            $table->char('no_identitas', 16)->nullable();
            $table->foreign('id_akses')
                ->references('id_akses')
                ->on('hak_akses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
