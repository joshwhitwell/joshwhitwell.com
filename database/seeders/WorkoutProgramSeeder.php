<?php

namespace Database\Seeders;

use App\Models\Lift\Set;
use App\Models\Lift\Week;
use App\Models\Lift\Phase;
use App\Models\Lift\SetLog;
use Illuminate\Support\Str;
use App\Models\Lift\Program;
use App\Models\Lift\WeekLog;
use App\Models\Lift\Workout;
use App\Models\Lift\Exercise;
use App\Models\Lift\PhaseLog;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\ProgramLog;
use App\Models\Lift\WorkoutLog;
use Illuminate\Database\Seeder;
use App\Models\Lift\WorkoutExercise;
use App\Models\Lift\WorkoutExerciseLog;

class WorkoutProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/public/ppl.csv');
        $handle = fopen($path, 'r');
        $index = null;
        $headers = null;
        $program = null;
        $phase = null;
        $phaseOrder = 1;
        $week = null;
        $weekOrder = 1;
        $day = null;
        $dayOrder = 1;
        $exercises = Exercise::all();
        $exercise = null;
        $exerciseOrder = 1;
        $setOrder = 1;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            // Row Number
            if (!isset($index)) {
                $index = 0;
            } else {
                $index++;
            }

            // Headers
            if (!empty($row[1]) && $row[1] === 'Exercise' && !isset($headers)) {
                $headers = array_map(function ($header) {
                    return Str::of($header)->replaceMatches('/[^A-Za-z0-9]/', '_')->lower()->toString();
                }, $row);
            }

            if (!empty($row[6]) && $row[6] === 'Set 1' && empty($headers[7])) {
                for ($i = 6; $i < 10; $i++) {
                    $headers[$i] = Str::of($row[$i])->replaceMatches('/[^A-Za-z0-9]/', '_')->lower()->toString();
                }
            }

            // Program
            if ($index === 0) {
                $program = Program::create(['name' => $row[0]]);
                continue;
            }

            // Phases
            if (strpos($row[0], 'PHASE') !== false) {
                $phase = Phase::create([
                    'program_id' => $program->id,
                    'name' => $row[0],
                    'order' => $phaseOrder,
                ]);
                $phaseOrder++;
                continue;
            }

            // Weeks
            if (
                strpos($row[0], 'Week') !== false
                && (empty($week->name)
                    || (!empty($week->name) && $week->name !== $row[0])
                )
            ) {
                $week = Week::create([
                    'program_id' => $program->id,
                    'phase_id' => $phase->id,
                    'name' => $row[0],
                    'order' => $weekOrder,
                ]);
                $weekOrder++;
            }

            // Days
            if (
                !empty($row[0])
                && (strpos($row[0], '#') !== false
                    || strpos($row[0], 'Rest') !== false
                )
            ) {
                $day = Workout::create([
                    'program_id' => $program->id,
                    'week_id' => $week->id,
                    'name' => $row[0],
                    'order' => $dayOrder,
                ]);
                $dayOrder++;
                $exerciseOrder = 1;
            }

            // Exercises
            if (!empty($row[1]) && $row[1] !== 'Exercise') {
                $row = array_combine($headers, $row);

                $exercise = $exercises->first(function ($exercise) use ($row) {
                    return strcasecmp($exercise->name, $row['exercise']) === 0;
                });

                if (!$exercise) {
                    $exercise = Exercise::create([
                        'name' => $row['exercise']
                    ]);
                    $exercises->push($exercise);
                }

                $sub1 = $exercises->first(function ($exercise) use ($row) {
                    return strcasecmp($exercise->name, $row['substitution_option_1']) === 0;
                });

                if (!$sub1) {
                    $sub1 = Exercise::create([
                        'name' => $row['substitution_option_1']
                    ]);
                    $exercises->push($sub1);
                }

                $sub2 = $exercises->first(function ($exercise) use ($row) {
                    return strcasecmp($exercise->name, $row['substitution_option_2']) === 0;
                });

                if (!$sub2) {
                    $sub2 = Exercise::create([
                        'name' => $row['substitution_option_2']
                    ]);
                    $exercises->push($sub2);
                }

                $workoutProgramDayExercise = WorkoutExercise::create([
                    'workout_id' => $day->id,
                    'exercise_id' => $exercise->id,
                    'order' => $exerciseOrder,
                    'min_rest' => preg_match('/\d+/', $row['rest'], $matches) ? (int)$matches[0] * 60 : null,
                    'max_rest' => preg_match_all('/\d+/', $row['rest'], $matches)
                        ? (int)end($matches[0]) * 60
                        : null,
                    'substitution_1_id' => $sub1->id,
                    'substitution_2_id' => $sub2->id,
                    'notes' => $row['notes']
                ]);

                $minWarmUps = preg_match('/\d/', $row['warm_up_sets'], $matches) ? (int)$matches[0] : null;
                $maxWarmUps = preg_match_all('/\d/', $row['warm_up_sets'], $matches)
                    ? (int)end($matches[0])
                    : null;

                if ($maxWarmUps) {
                    while ($setOrder <= $maxWarmUps) {
                        Set::create([
                            'workout_exercise_id' => $workoutProgramDayExercise->id,
                            'order' => $setOrder,
                            'is_warm_up' => true,
                            'is_optional' => empty($minWarmUps) || $setOrder > $minWarmUps
                        ]);
                        $setOrder++;
                    }
                    $setOrder = 1;
                }

                $minSets = preg_match('/\d/', $row['working_sets'], $matches) ? (int)$matches[0] : null;
                $maxSets = preg_match_all('/\d/', $row['working_sets'], $matches)
                    ? (int)end($matches[0])
                    : null;

                if ($maxSets) {
                    while ($setOrder <= $maxSets) {
                        Set::create([
                            'workout_exercise_id' => $workoutProgramDayExercise->id,
                            'order' => $setOrder,
                            'is_warm_up' => false,
                            'is_optional' => empty($minSets) || $setOrder > $minSets,
                            'min_reps' => strpos($row['reps'], '-') !== false ? (int)explode('-', $row['reps'])[0] : (int)$row['reps'],
                            'max_reps' => strpos($row['reps'], '-') !== false ? (int)explode('-', $row['reps'])[1] : (int)$row['reps'],
                            'rpe' => $setOrder === $maxSets && !empty($row['last_set_rpe'])
                                ? $row['last_set_rpe']
                                : (!empty($row['early_set_rpe'])
                                    ? $row['early_set_rpe']
                                    : null
                                ),
                            'intensity_technique' => !empty($row['last_set_intensity_technique'])
                                && $row['last_set_intensity_technique'] !== 'N/A'
                                && $setOrder === $maxSets
                                ? $row['last_set_intensity_technique']
                                : null,
                        ]);
                        $setOrder++;
                    }
                    $setOrder = 1;
                }

                $exerciseOrder++;
                $setOrder = 1;
            }
        }

        fclose($handle);

        $this->initProgramLog();
    }

    public function initProgramLog()
    {
        $startedAt = now();
        $program = Program::with([
            'phases',
            'phases.weeks',
            'phases.weeks.workouts',
            'phases.weeks.workouts.workoutExercises',
            'phases.weeks.workouts.workoutExercises.sets'
        ])->first();
        $programLog = ProgramLog::create([
            'user_id' => 1,
            'program_id' => $program->id,
            'status' => LiftStatus::IN_PROGRESS,
            'started_at' => $startedAt,
        ]);

        foreach ($program->phases as $phase) {
            $phaseLog = PhaseLog::create([
                'user_id' => 1,
                'program_log_id' => $programLog->id,
                'phase_id' => $phase->id,
                'status' => LiftStatus::NOT_STARTED,
            ]);

            foreach ($phase->weeks as $week) {
                $weekLog = WeekLog::create([
                    'user_id' => 1,
                    'program_log_id' => $programLog->id,
                    'phase_log_id' => $phaseLog->id,
                    'week_id' => $week->id,
                    'status' => LiftStatus::NOT_STARTED,
                ]);

                foreach ($week->workouts as $workout) {
                    $workoutLog = WorkoutLog::create([
                        'user_id' => 1,
                        'program_log_id' => $programLog->id,
                        'phase_log_id' => $phaseLog->id,
                        'week_log_id' => $weekLog->id,
                        'workout_id' => $workout->id,
                        'status' => LiftStatus::NOT_STARTED,
                    ]);

                    foreach ($workout->workoutExercises as $workoutExercise) {
                        $workoutExerciseLog = WorkoutExerciseLog::create([
                            'user_id' => 1,
                            'workout_log_id' => $workoutLog->id,
                            'workout_exercise_id' => $workoutExercise->id,
                            'status' => LiftStatus::NOT_STARTED,
                        ]);

                        foreach ($workoutExercise->sets as $set) {
                            SetLog::create([
                                'user_id' => 1,
                                'workout_exercise_log_id' => $workoutExerciseLog->id,
                                'set_id' => $set->id,
                                'status' => LiftStatus::NOT_STARTED,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
