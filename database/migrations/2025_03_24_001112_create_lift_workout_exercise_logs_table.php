<?php

use App\Enums\Lift\LiftStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lift_workout_exercise_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workout_log_id')->constrained('lift_workout_logs')->cascadeOnDelete();
            $table->foreignId('workout_exercise_id')->constrained('lift_workout_exercises')->cascadeOnDelete();
            $table->string('status')->default(LiftStatus::NotStarted);
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->unsignedTinyInteger('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_exercise_logs');
    }
};
