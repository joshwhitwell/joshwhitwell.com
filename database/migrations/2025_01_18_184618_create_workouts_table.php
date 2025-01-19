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
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_program_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('workout_program_phase_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('workout_program_week_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
