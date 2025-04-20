<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Models\Lift\Program;
use App\Models\Lift\Exercise;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Models\Lift\WorkoutExercise;

class ImportWorkoutProgram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-workout-program {filename : The name of the file to import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public ?Collection $exercises = null;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Open the file based on the filename argument.
        // Error if the file does not exist, cannot be read, or is empty.
        $filename = $this->argument('filename');
        $path = storage_path('app/public/workout-programs/' . $filename);

        if (!file_exists($path)) {
            $this->error("The file '{$filename}' does not exist at the specified path.");

            return Command::FAILURE;
        }

        $handle = fopen($path, 'r');

        if ($handle === false) {
            $this->error("Failed to open the file '{$filename}'.");

            return Command::FAILURE;
        }

        if (feof($handle)) {
            $this->error("The file '{$filename}' is empty.");

            fclose($handle);

            return Command::FAILURE;
        }

        // Convert the filename to the program name, then create a new program by that name.
        // Error if there is no name, or there is already a program with the same name.
        $programName = Str::of($filename)->replace('.csv', '')->replace('-', ' ')->title()->toString();

        if (empty($programName) || Program::where('name', $programName)->exists()) {
            $this->error("The program name is either empty or already exists.");

            return Command::FAILURE;
        }

        // Load existing exercises.
        $this->exercises = Exercise::all();

        // Initialize import vars.
        $program = Program::create(['name' => $programName]);
        $weekOrder = 1;
        $week = null;
        $workoutOrder = 1;
        $workout = null;
        $workoutExerciseOrder = 1;
        $workoutExercise = null;

        // Import the file data.
        while (($row = fgetcsv($handle)) !== false) {
            // Skip empty rows.
            if (empty($row[0]) && empty($row[1])) {
                continue;
            }

            // Handle week.
            if (str_starts_with($row[0], 'Week')) {
                $week = $program->weeks()->create(['name' => $row[0], 'order' => $weekOrder]);

                $workoutOrder = 1;
                $weekOrder++;

                continue;
            }

            // Handle workout.
            if (!empty($row[0]) && !empty($week)) {
                $workout = $week->workouts()->create([
                    'name' => $row[0],
                    'program_id' => $program->id,
                    'order' => $workoutOrder
                ]);

                $workoutExerciseOrder = 1;
                $workoutOrder++;
            }

            // Handle exercise.
            if (!empty($row[1]) && !empty($workout)) {
                $exercise = $this->getExercise($row[1], $row[2]);

                if (empty($exercise)) {
                    continue;
                }

                $rest = $this->getRest($row[8]);
                $substitution1 = $this->getExercise($row[9], $row[10]);
                $substitution2 = $this->getExercise($row[11], $row[12]);
                $workoutExercise = $workout->workoutExercises()->create([
                    'exercise_id' => $exercise->id,
                    'order' => $workoutExerciseOrder,
                    'min_rest' => $rest[0] ?? 0,
                    'max_rest' => $rest[1] ?? 0,
                    'substitution_1_id' => $substitution1->id ?? null,
                    'substitution_2_id' => $substitution2->id ?? null,
                    'notes' => !empty(trim($row[13])) ? trim($row[13]) : null,
                ]);

                $workoutExerciseOrder++;

                $this->handleSets($workoutExercise, $row);
            }
        }

        fclose($handle);
    }

    public function getExercise(string $exerciseName, string $exerciseUrl): ?Exercise
    {
        $exerciseName = str_replace(
            ['(Heavy)', '(Back off)', 'A1:', 'A2:'],
            '',
            $exerciseName
        );
        $exerciseName = trim($exerciseName);
        $exerciseUrl = trim($exerciseUrl);

        if (empty($exerciseName)) {
            return null;
        }

        $exercise = $this->exercises->first(function ($exercise) use ($exerciseName) {
            return strcasecmp($exercise->name, $exerciseName) === 0;
        });

        if ($exercise) {
            if (empty($exercise->video_url) && !empty($exerciseUrl)) {
                $exercise->video_url = $exerciseUrl;
                $exercise->save();
            }

            return $exercise;
        }

        $exercise = Exercise::create(['name' => $exerciseName]);

        $this->exercises->put($exercise->name, $exercise);

        return $exercise;
    }

    public function getRest(string $rest): ?array
    {
        $rest = str_replace(
            ['~', 'min'],
            '',
            $rest
        );
        $rest = trim($rest);

        if (empty($rest)) {
            return null;
        }

        $rest = explode('-', $rest);

        return [
            ((float) ($rest[0] ?? 0)) * 60,
            ((float) ($rest[1] ?? $rest[0] ?? 0)) * 60
        ];
    }

    public function handleSets(WorkoutExercise $workoutExercise, array $row): void
    {
        $setOrder = 1;
        $minWarmUps = preg_match('/\d/', $row[3], $matches)
            ? (int) $matches[0]
            : null;
        $maxWarmUps = preg_match_all('/\d/', $row[3], $matches)
            ? (int) end($matches[0])
            : null;

        if ($maxWarmUps) {
            while ($setOrder <= $maxWarmUps) {
                $workoutExercise->sets()->create([
                    'order' => $setOrder,
                    'is_warm_up' => true,
                    'is_optional' => empty($minWarmUps) || $setOrder > $minWarmUps
                ]);

                $setOrder++;
            }

            $setOrder = 1;
        }

        $minSets = preg_match('/\d/', $row[4], $matches)
            ? (int) $matches[0]
            : null;
        $maxSets = preg_match_all('/\d/', $row[4], $matches)
            ? (int) end($matches[0])
            : null;

        if ($maxSets) {
            while ($setOrder <= $maxSets) {
                $reps = $this->getReps($row[5]);
                $workoutExercise->sets()->create([
                    'order' => $setOrder,
                    'is_optional' => empty($minSets) || $setOrder > $minSets,
                    'min_reps' => $reps[0],
                    'max_reps' => $reps[1],
                    'rpe' => $row[7],
                    'intensity_technique' => $this->getIntensityTechnique($row[5]),
                ]);

                $setOrder++;
            }
        }
    }

    public function getReps(string $reps): array
    {
        $reps = preg_replace('/[^\d-]/', '', $reps);
        $reps = trim($reps);

        if (empty($reps)) {
            return [null, null];
        }

        $reps = explode('-', $reps);

        return [
            (int) ($reps[0] ?? 0),
            (int) ($reps[1] ?? $reps[0] ?? 0)
        ];
    }

    public function getIntensityTechnique(string $reps): ?string
    {
        $intensityTechnique = preg_replace('/[\d\-\(\)]/', '', $reps);
        $intensityTechnique = trim($intensityTechnique);

        return empty($intensityTechnique) ? null : strtolower($intensityTechnique);
    }
}
