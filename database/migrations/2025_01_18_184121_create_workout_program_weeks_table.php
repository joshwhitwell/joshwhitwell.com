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
        Schema::create('workout_program_weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workout_program_phase_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_program_weeks');
    }
};
