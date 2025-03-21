<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\WorkoutProgram;
use Illuminate\Database\Seeder;
use App\Models\WorkoutProgramDay;
use App\Models\WorkoutProgramWeek;
use App\Models\WorkoutProgramPhase;

class WorkoutProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // phpcs:ignore
        $path = storage_path('app/public/ppl.csv');
        $handle = fopen($path, 'r');
        $index = null;
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

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (!isset($index)) {
                $index = 0;
            } else {
                $index++;
            }

            // Program
            if ($index === 0) {
                $program = WorkoutProgram::create(['name' => $row[0]]);
                continue;
            }

            // Phases
            if (strpos($row[0], 'PHASE') !== false) {
                $phase = WorkoutProgramPhase::create([
                    'workout_program_id' => $program->id,
                    'name' => $row[0],
                    'order' => $phaseOrder,
                ]);
                $phaseOrder++;
                continue;
            }

            // Weeks
            if (strpos($row[0], 'Week') !== false
                && (empty($week->name)
                    || (!empty($week->name) && $week->name !== $row[0])
                )
            ) {
                $week = WorkoutProgramWeek::create([
                    'workout_program_id' => $program->id,
                    'workout_program_phase_id' => $phase->id,
                    'name' => $row[0],
                    'order' => $weekOrder,
                ]);
                $weekOrder++;
            }

            if (!empty($row[0])
                && (strpos($row[0], '#') !== false
                    || strpos($row[0], 'Rest') !== false
                )
            ) {
                $day = WorkoutProgramDay::create([
                    'workout_program_id' => $program->id,
                    'workout_program_week_id' => $week->id,
                    'name' => $row[0],
                    'order' => $dayOrder,
                ]);
                $dayOrder++;
            }

            if (!empty($row[1]) && $row[1] !== 'Exercise') {
                $exercise = $exercises->firstWhere('name', $row[1]);

                if (!$exercise) {
                    $exercise = Exercise::create([
                        'name' => $row[1]
                    ]);
                    $exercises->push($exercise);
                }

                $exerciseOrder++;
            }
        }

        fclose($handle);
    }
}
