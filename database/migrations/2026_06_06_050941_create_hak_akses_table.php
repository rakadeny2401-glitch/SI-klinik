<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hak_akses', function (Blueprint $table) {
            $table->id('id_akses');
            $table->string('nama_akses', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hak_akses');
    }
};