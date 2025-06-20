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
        Schema::create('lift_weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('lift_programs')->cascadeOnDelete();
            $table->foreignId('phase_id')->constrained('lift_phases')->cascadeOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_weeks');
    }
};
