<?php

namespace Database\Seeders;

use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Str;
use App\Models\WorkoutProgram;
use Illuminate\Database\Seeder;
use App\Models\WorkoutProgramWeek;
use Illuminate\Support\Facades\DB;
use App\Models\WorkoutProgramPhase;

class WorkoutProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/public/ppl.csv');
        $handle = fopen($path, 'r');
        $json = [];

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (!isset($rowNumber)) {
                $rowNumber = 0;
            } else {
                $rowNumber++;
            }

            if ($rowNumber === 0) {
                $workoutProgram = WorkoutProgram::create(['name' => $row[0]]);
                continue;
            }

            if ($rowNumber < 56 || empty(array_filter($row))) {
                continue;
            }

            if ($rowNumber === 56) {
                $workoutProgramPhase = WorkoutProgramPhase::create([
                    'workout_program_id' => $workoutProgram->id,
                    'name' => $row[0],
                    'order' => (DB::table('workout_program_phases')
                        ->where('workout_program_id', $workoutProgram->id)
                        ->orderBy('order')
                        ->max('order') ?? 0) + 1
                ]);
                continue;
            }

            if ($rowNumber === 57) {
                $headers = $row;
                continue;
            }

            if ($rowNumber === 58) {
                for ($i = 6; $i < 10; $i++) {
                    $headers[$i] = $row[$i];
                }
                continue;
            }

            $row = array_combine($headers, $row);

            dd($rowNumber, $row);
        }

        fclose($handle);
    }
        // for ($i = 1; $i <= 160; $i++) {
        //     Exercise::create([
        //         // phpcs:ignore
        //         'name' => Str::title(fake()->unique()->catchPhrase())
        //     ]);
        // }

        // $workoutDescriptions = [
        //     "Pull #1 (Lat Focused)",
        //     "Push #1",
        //     "Optional Rest Day",
        //     "Legs #1",
        //     "Arms & Weak Points #1",
        //     "Mandatory Rest Day",
        //     "Week 1",
        //     "Pull #2 (Mid-Back Focused)",
        //     "Push #2",
        //     "Optional Rest Day",
        //     "Legs #2",
        //     "Arms & Weak Points #2",
        //     "Mandatory Rest Day"
        // ];

        // foreach ([
        //     "Pull #1 (Lat Focused)",
        //     "Push #1",
        //     "Optional Rest Day",
        //     "Legs #1",
        //     "Arms & Weak Points #1",
        //     "Mandatory Rest Day",
        //     "Week 1",
        //     "Pull #2 (Mid-Back Focused)",
        //     "Push #2",
        //     "Optional Rest Day",
        //     "Legs #2",
        //     "Arms & Weak Points #2",
        //     "Mandatory Rest Day"
        // ] as $workoutName) {
        //     Workout::create([
        //         'name' => $workoutName
        //     ]);
        // }
        // $workoutProgram = WorkoutProgram::create([
        //     // phpcs:ignore
        //     'name' => Str::title('THE PURE BODYBUILDING PROGRAM - PUSH PULL LEGS & ARMS')
        // ]);

        // foreach (['BLOCK 1: 5-WEEK BUILD PHASE', 'BLOCK 2: 5-WEEK NOVELTY PHASE'] as $phaseNumber => $phaseName) {
        //     $workoutProgramPhase = WorkoutProgramPhase::create([
        //         'workout_program_id' => $workoutProgram->id,
        //         'name' => Str::title($phaseName),
        //         'order' => $phaseNumber + 1
        //     ])

        //     for ($weekNumber = ($phaseNumber === 0 ? 1 : 6); $weekNumber <= ($phaseNumber === 0 ? 5 : 10); $weekNumber++) {
        //         $workoutProgramWeek = WorkoutProgramWeek::create([
        //             'workout_program_id' => $workoutProgram->id,
        //             'workout_program_phase_id' => $workoutProgramPhase->id,
        //             'name' => 'Week ' . $weekNumber,
        //             'order' => $weekNumber,
        //         ]);
        //     }
        // }


        // for ($workoutProgramIndex = 1; $workoutProgramIndex <= 10; $workoutProgramIndex++) {
        //     $workoutProgram = WorkoutProgram::create([
        //         // phpcs:ignore
        //         'name' => Str::title(fake()->unique()->catchPhrase())
        //     ]);

        //     $workoutProgramPhases = [];
        //     if (rand(0, 1) === 1) {
        //         for ($workoutProgramPhaseIndex = 1; $workoutProgramPhaseIndex <= rand(1, 3); $workoutProgramPhaseIndex++) {
        //             $workoutProgramPhases[] = WorkoutProgramPhase::create([
        //                 'workout_program_id' => $workoutProgram->id,
        //                 'name' => 'Phase '.$workoutProgramPhaseIndex,
        //                 'order' => $workoutProgramPhaseIndex,
        //             ]);
        //         }
        //     }

        //     $workoutProgramWeeks = [];
        //     if (rand(0, 1) === 1) {
        //         for ($workoutProgramWeekIndex = 1; $workoutProgramWeekIndex <= rand(1, 12); $workoutProgramWeekIndex++) {
        //             $workoutProgramWeeks[] = WorkoutProgramWeek::create([
        //                 'workout_program_id' => $workoutProgram->id,
        //                 'name' => 'Week '.$workoutProgramWeekIndex,
        //                 'order' => $workoutProgramWeekIndex,
        //             ]);
        //         }
        //     }
        // }
}
