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
        Schema::create('workout_program_day_exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_program_day_exercise_id')->constrained(indexName: 'wpde_sets_wpde_id_foreign')->cascadeOnDelete();
            $table->unsignedTinyInteger('order');
            $table->boolean('is_warm_up')->default(false);
            $table->boolean('is_optional')->default(false);
            $table->unsignedTinyInteger('min_reps')->nullable();
            $table->unsignedTinyInteger('max_reps')->nullable();
            $table->string('rpe')->nullable();
            $table->string('intensity_technique')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_program_day_exercise_sets');
    }
};
