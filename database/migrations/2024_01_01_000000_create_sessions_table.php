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
        // Sessions table already exists in database
        // This migration is just a placeholder to track it in migrations table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop - table should be managed manually
    }
};
