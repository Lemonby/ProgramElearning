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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_url');
            $table->timestamp('submitted_at')->useCurrent();
            // $table->decimal('grade', 5, 2)->nullable();
            // $table->text('feedback')->nullable();
            $table->timestamp('graded_at')->nullable();
            
            // Memastikan member hanya bisa mengumpulkan 1 kali per tugas
            $table->unique(['assignment_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
