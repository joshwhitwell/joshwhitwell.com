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
        Schema::create('lift_workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->nullable()->constrained('lift_programs')->cascadeOnDelete();
            $table->foreignId('phase_id')->nullable()->constrained('lift_phases')->cascadeOnDelete();
            $table->foreignId('week_id')->nullable()->constrained('lift_weeks')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_workouts');
    }
};
