<?php

namespace App\Actions\Lift;

use App\Models\User;
use App\Models\Lift\Program;
use App\Models\Lift\ProgramLog;

class InitializeProgramLogAction
{
    public function __invoke(Program $program, User $user): ProgramLog
    {
        $programLog = ProgramLog::create([
            'program_id' => $program->id,
            'user_id' => $user->id,
        ]);
        $phaseLogs = [];
        $weekLogs = [];

        // Phases
        if (!empty($program->phases)) {
            foreach ($program->phases as $phase) {
                $phaseLog = $phase->phaseLogs()->create([
                    'user_id' => $user->id,
                    'program_log_id' => $programLog->id,
                    'order' => $phase->order
                ]);

                $phaseLogs[$phase->id] = $phaseLog->id;
            }
        }

        // Weeks
        if (!empty($program->weeks)) {
            foreach ($program->weeks as $week) {
                $weekLog = $week->weekLogs()->create([
                    'user_id' => $user->id,
                    'program_log_id' => $programLog->id,
                    'phase_log_id' => $phaseLogs[$week->phase_id],
                    'order' => $week->order
                ]);

                $weekLogs[$week->id] = $weekLog->id;
            }
        }

        // Workouts
        if (!empty($program->workouts)) {
            $program->workouts->load(['workoutExercises']);

            foreach ($program->workouts as $workout) {
                $workoutLog = $workout->workoutLogs()->create([
                    'user_id' => $user->id,
                    'program_log_id' => $programLog->id,
                    'phase_log_id' => $phaseLogs[$workout->phase_id],
                    'week_log_id' => $weekLogs[$workout->week_id],
                    'order' => $workout->order
                ]);

                // Workout Exercises
                if (!empty($workout->workoutExercises)) {
                    $workout->workoutExercises->load(['sets']);

                    foreach ($workout->workoutExercises as $workoutExercise) {
                        $workoutExerciseLog = $workoutExercise->workoutExerciseLogs()->create([
                            'user_id' => $user->id,
                            'workout_log_id' => $workoutLog->id,
                            'workout_exercise_id' => $workoutExercise->id,
                            'order' => $workoutExercise->order
                        ]);

                        // Sets
                        if (!empty($workoutExercise->sets)) {
                            foreach ($workoutExercise->sets as $set) {
                                $set->setLogs()->create([
                                    'user_id' => $user->id,
                                    'workout_exercise_log_id' => $workoutExerciseLog->id,
                                    'set_id' => $set->id,
                                    'order' => $set->order,
                                    'is_warm_up' => $set->is_warm_up
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return $programLog;
    }
}
