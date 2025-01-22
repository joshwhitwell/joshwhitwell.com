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
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workout_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_1_id')->nullable()->constrained('exercises')->nullOnDelete();
            $table->foreignId('sub_2_id')->nullable()->constrained('exercises')->nullOnDelete();
            $table->integer('order');
            $table->string('last_set_intensity_technique')->nullable();
            $table->integer('min_warm_up_sets')->default(0);
            $table->integer('max_warm_up_sets')->default(0);
            $table->integer('min_sets')->default(0);
            $table->integer('max_sets')->default(0);
            $table->string('reps')->nullable();
            $table->string('early_set_rpe')->nullable();
            $table->string('last_set_rpe')->nullable();
            $table->integer('min_rest')->default(0);
            $table->integer('max_rest')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
    }
};
