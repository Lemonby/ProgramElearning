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
        // Meetings table sudah punya class_id, jadi migration ini cukup untuk ensure struct
        if (!Schema::hasColumn('meetings', 'class_id')) {
            Schema::table('meetings', function (Blueprint $table) {
                $table->foreignId('class_id')
                      ->after('id')
                      ->constrained('classes')
                      ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            if (Schema::hasColumn('meetings', 'class_id')) {
                $table->dropConstrainedForeignId('class_id');
            }
        });
    }
};
