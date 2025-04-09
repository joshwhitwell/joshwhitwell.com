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
        Schema::create('lift_workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lift_workout_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lift_exercise_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('order');
            $table->unsignedSmallInteger('min_rest')->nullable();
            $table->unsignedSmallInteger('max_rest')->nullable();
            $table->foreignId('substitution_1_id')->nullable()->constrained('lift_exercises')->nullOnDelete();
            $table->foreignId('substitution_2_id')->nullable()->constrained('lift_exercises')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_workout_exercises');
    }
};
