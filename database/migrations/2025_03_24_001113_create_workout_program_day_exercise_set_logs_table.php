<?php

use App\Enums\WorkoutProgramStatus;
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
        Schema::create('workout_program_day_exercise_set_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workout_program_day_exercise_set_id')->constrained(indexName: 'wpdes_id_foreign')->cascadeOnDelete();
            $table->foreignId('workout_program_day_exercise_log_id')->constrained(indexName: 'wpdel_id_foreign')->cascadeOnDelete();
            $table->unsignedSmallInteger('reps')->nullable();
            $table->float('weight')->nullable();
            $table->unsignedSmallInteger('duration')->nullable();
            $table->string('status')->default(WorkoutProgramStatus::NOT_STARTED);
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
        Schema::dropIfExists('workout_program_day_exercise_set_logs');
    }
};
