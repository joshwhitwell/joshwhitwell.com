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
        Schema::create('lift_exercise_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('lift_exercises')->cascadeOnDelete();
            $table->string('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_exercise_videos');
    }
};
