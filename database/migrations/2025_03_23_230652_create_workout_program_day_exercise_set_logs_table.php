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
        Schema::create('workout_program_day_exercise_set_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workout_program_day_exercise_set_id')->constrained(indexName: 'wpdes_id_foreign')->cascadeOnDelete();
            $table->unsignedSmallInteger('reps')->nullable();
            $table->float('weight')->nullable();
            $table->unsignedSmallInteger('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_program_day_exercise_set_logs');
    }
};
