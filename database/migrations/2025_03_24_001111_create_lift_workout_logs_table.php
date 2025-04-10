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
        Schema::create('lift_workout_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_log_id')->nullable()->constrained('lift_program_logs')->cascadeOnDelete();
            $table->foreignId('phase_log_id')->nullable()->constrained('lift_phase_logs')->cascadeOnDelete();
            $table->foreignId('week_log_id')->nullable()->constrained('lift_week_logs')->cascadeOnDelete();
            $table->foreignId('workout_id')->constrained('lift_workouts')->cascadeOnDelete();
            $table->string('status')->default(LiftStatus::NotStarted);
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lift_workout_logs');
    }
};
