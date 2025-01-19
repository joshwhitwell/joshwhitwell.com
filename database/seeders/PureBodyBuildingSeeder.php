<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\WorkoutProgram;
use Illuminate\Database\Seeder;

class PureBodyBuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (($handle = fopen(storage_path('app/public/ppl-new.csv'), 'r')) === false) {
            return;
        }

        $workoutProgram = WorkoutProgram::where('slug', 'pure-bodybuilding-ppl')->first();

        if ($workoutProgram) {
            $workoutProgram->workouts()->delete();
            $workoutProgram->weeks()->delete();
            $workoutProgram->phases()->delete();
            $workoutProgram->delete();
        }

        $workoutProgram = WorkoutProgram::create([
            'slug' => 'pure-bodybuilding-ppl',
            'name' => 'The Pure Bodybuilding Program Push Pull Legs',
        ]);

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (empty(array_filter($row))) {
                continue;
            }

            if (strpos($row[0], 'BLOCK') === 0) {
                if (!isset($workoutProgramPhase) || $workoutProgramPhase->name !== $row[0]) {
                    $workoutProgramPhase = $workoutProgram->phases()->updateOrCreate([
                        'name' => $row[0],
                    ], [
                        'order' => isset($workoutProgramPhase) ? $workoutProgramPhase->order + 1 : 1,
                    ]);
                }

                continue;
            }

            if (strpos($row[0], 'Week') === 0) {
                if (!isset($headers)) {
                    $headers = array_map(function($value) {
                        return $this->getSnakeCaseKey($value);
                    }, $row);
                    $headers[0] = 'block';
                }

                if (!isset($workoutProgramWeek) || $workoutProgramWeek->name !== $row[0]) {
                    $workoutProgramWeek = $workoutProgramPhase->weeks()->updateOrCreate([
                        'workout_program_id' => $workoutProgram->id,
                        'name' => $row[0],
                    ], [
                        'order' => isset($workoutProgramWeek) ? $workoutProgramWeek->order + 1 : 1,
                    ]);
                }

                continue;
            }

            if (strpos($row[8], 'Set') === 0 && empty($headers[8])) {
                foreach ([7,8,9,10] as $i) {
                    $headers[$i] = $this->getSnakeCaseKey($row[$i]);
                }

                continue;
            }

            $row = array_map(function($value) {
                return trim(str_replace("\n", '', $value));
            }, $row);
            $row = array_combine($headers, $row);

            if (!empty($row['block'])
                && (strpos($row['block'], '#') !== false
                    || strpos($row['block'], 'Rest') !== false
                )
            ) {
                if ($row['block'] === 'Pull #2(Mid-Back Focused)') {
                    $row['block'] = 'Pull #2 (Mid-Back Focused)';
                }

                $workout = $workoutProgramWeek->workouts()->create([
                    'workout_program_id' => $workoutProgram->id,
                    'workout_program_phase_id' => $workoutProgramPhase->id,
                    'workout_program_week_id' => $workoutProgramWeek->id,
                    'name' => $row['block'],
                    'order' => isset($workout) ? $workout->order + 1 : 1,
                ]);
                $exerciseOrder = 1;
            }

            $exercise = null;
            $subExerciseOne = null;
            $subExerciseTwo = null;

            if (!empty($row['exercise'])) {
                $name = $this->normalizeExerciseName($row['exercise']);
                $exercise = Exercise::updateOrCreate([
                    'name' => $name,
                ], [
                    'url' => $this->parseLink($row['exercise_link']),
                ]);
            }

            if (!empty($row['substitution_option_1'])) {
                $name = $this->normalizeExerciseName($row['substitution_option_1']);
                $subExerciseOne = Exercise::updateOrCreate([
                    'name' => $name,
                ], [
                    'url' => $this->parseLink($row['sub_1_link']),
                ]);
            }

            if (!empty($row['substitution_option_2'])) {
                $name = $this->normalizeExerciseName($row['substitution_option_2']);
                $subExerciseTwo = Exercise::updateOrCreate([
                    'name' => $name,
                ], [
                    'url' => $this->parseLink($row['sub_2_link']),
                ]);
            }

            if ($exercise) {
                $workout->exerciseWorkouts()->create([
                    'exercise_id' => $exercise->id,
                    'sub_1_id' => $subExerciseOne ? $subExerciseOne->id : null,
                    'sub_2_id' => $subExerciseTwo ? $subExerciseTwo->id : null,
                    'order' => $exerciseOrder,
                    'last_set_intensity_technique' => $row['last_set_intensity_technique'] !== 'N/A'
                        ? $row['last_set_intensity_technique']
                        : null,
                    'min_warm_up_sets' => is_string($row['warm_up_sets'])
                        ? min(array_map('intval', explode('-', $row['warm_up_sets'])))
                        : 0,
                    'max_warm_up_sets' => is_string($row['warm_up_sets'])
                        ? max(array_map('intval', explode('-', $row['warm_up_sets'])))
                        : 0,
                    'min_sets' => is_string($row['working_sets'])
                        ? min(array_map('intval', explode('-', $row['working_sets'])))
                        : 0,
                    'max_sets' => is_string($row['working_sets'])
                        ? max(array_map('intval', explode('-', $row['working_sets'])))
                        : 0,
                    'reps' => is_string($row['reps'])
                        ? explode(',', $row['reps'])
                        : null,
                    'early_set_rpe' => $row['early_set_rpe'],
                    'last_set_rpe' => $row['last_set_rpe'],
                    'min_rest' => is_string($row['rest'])
                        ? min(array_map(function($value) {
                            return intval(preg_replace('/\D/', '', $value)) * 60;
                        }, explode('-', $row['rest'])))
                        : 0,
                    'max_rest' => is_string($row['rest'])
                        ? max(array_map(function($value) {
                            return intval(preg_replace('/\D/', '', $value)) * 60;
                        }, explode('-', $row['rest'])))
                        : 0,
                    'notes' => $row['notes'],
                ]);

                $exerciseOrder++;
            }
        }

        fclose($handle);
    }

    public function getSnakeCaseKey(string $key): string
    {
        $key = preg_replace('/[^a-zA-Z0-9]/', ' ', $key);
        return strtolower(preg_replace('/\s+/', '_', trim($key)));
    }

    public function normalizeExerciseName(string $name): string
    {
        $name = str_replace(['A1: ', 'A2: '], '', $name);
        $name = str_replace('DB', 'Dumbbell', $name);
        $name = str_replace('-', ' ', $name);
        $name = str_replace('RDL', 'Romanian Deadlift', $name);

        return trim($name);
    }

    public function parseLink(?string $link): ?string
    {
        return !empty($link) && $link !== '#REF!' ? $link : null;
    }
}
