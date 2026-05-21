<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - DEPRECATED (use 2026_05_20_000000_add_class_id_to_meetings_table instead)
     */
    public function up(): void
    {
        // Already handled in 2026_05_20_000000_add_class_id_to_meetings_table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
