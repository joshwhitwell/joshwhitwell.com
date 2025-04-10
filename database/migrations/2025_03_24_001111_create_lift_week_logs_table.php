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
        Schema::create('lift_week_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_log_id')->constrained('lift_program_logs')->cascadeOnDelete();
            $table->foreignId('phase_log_id')->nullable()->constrained('lift_phase_logs')->cascadeOnDelete();
            $table->foreignId('week_id')->constrained('lift_weeks')->cascadeOnDelete();
            $table->string('status')->default(LiftStatus::NOT_STARTED);
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
        Schema::dropIfExists('lift_week_logs');
    }
};
