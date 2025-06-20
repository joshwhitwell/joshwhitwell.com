<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Lift\Program;
use App\Models\Lift\Exercise;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use App\Models\Lift\WorkoutExercise;
use App\Actions\Lift\InitializeProgramLogAction;

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
        $programName = Str::of($filename)
            ->beforeLast('.')
            ->replace(':', '/')
            ->toString();
        $programKey = Str::of($programName)
            ->replaceMatches('/[^a-zA-Z0-9]/', '')
            ->lower()
            ->toString();

        if (empty($programKey) || Program::where('key', $programKey)->exists()) {
            $this->error("The provided program key is either invalid or already exists.");

            return Command::FAILURE;
        }

        // Load existing exercises.
        $this->exercises = Exercise::all();

        // Initialize import vars.
        $program = Program::create(['key' => $programKey, 'name' => $programName]);
        $phaseOrder = 1;
        $phase = $program->phases()->create(['name' => 'Phase 1', 'order' => $phaseOrder]);
        $weekOrder = 1;
        $week = null;
        $workoutOrder = 1;
        $workout = null;
        $workoutExerciseOrder = 1;
        $workoutExercise = null;
        $headers = fgetcsv($handle);

        // Import the file data.
        while (($row = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, $row);

            // Skip empty rows.
            if (empty($row['week_workout']) && empty($row['exercise'])) {
                continue;
            }

            // Handle week.
            if (str_starts_with($row['week_workout'], 'Week')) {
                $week = $phase->weeks()->create([
                    'program_id' => $program->id,
                    'name' => $row['week_workout'],
                    'order' => $weekOrder
                ]);

                $weekOrder++;

                continue;
            }

            // Handle workout.
            if (!empty($row['week_workout']) && !empty($week)) {
                $workoutName = Str::of($row['week_workout'])
                    ->title()
                    ->toString();
                if (str_contains($workoutName, 'Rest')) {
                    $workoutName = 'Suggested Rest Day';
                }
                $workout = $week->workouts()->create([
                    'program_id' => $program->id,
                    'phase_id' => $phase->id,
                    'name' => $workoutName,
                    'order' => $workoutOrder
                ]);

                $workoutExerciseOrder = 1;
                $workoutOrder++;
            }

            // Handle exercise.
            if (!empty($row['exercise']) && !empty($workout)) {
                $exercise = $this->getExercise($row['exercise'], $row['exercise_url']);

                if (empty($exercise)) {
                    continue;
                }

                $rest = $this->getRest($row['rest']);
                $substitution1 = $this->getExercise($row['sub_1'], $row['sub_1_url']);
                $substitution2 = $this->getExercise($row['sub_2'], $row['sub_2_url']);
                $notes = Str::of($row['notes'])
                    ->trim()
                    ->toString();
                $workoutExercise = $workout->workoutExercises()->create([
                    'exercise_id' => $exercise->id,
                    'order' => $workoutExerciseOrder,
                    'min_rest' => $rest[0] ?? 0,
                    'max_rest' => $rest[1] ?? 0,
                    'substitution_1_id' => $substitution1->id ?? null,
                    'substitution_2_id' => $substitution2->id ?? null,
                    'notes' => $notes ?: null,
                ]);

                $workoutExerciseOrder++;

                $this->handleSets($workoutExercise, $row);
            }
        }

        fclose($handle);

        // Create and invoke InitializeProgramLogAction
        $admin = User::find(1);
        if ($admin) {
            (new InitializeProgramLogAction)($program, User::find(1));
        }

        return Command::SUCCESS;
    }

    public function getExercise(string $exercise, string $url): ?Exercise
    {
        $exerciseName = Str::of($exercise)
            // Removes e.g. 'A1.' or 'A1:'
            ->replaceMatches('/[A-C][1-4][\.:]?\s*/', '')
            // Removes parenthetical text
            ->replaceMatches('/\([^)]+\)/', '')
            // Removes e.g. '5"'
            ->replaceMatches('/[2-5]"/', '')
            // Replace non-alpha-numeric characters with spaces
            ->replaceMatches('/[^a-zA-Z0-9\s]/', ' ')
            ->title()
            ->trim()
            ->toString();
        $exerciseKey = Str::of($exerciseName)
            ->replaceMatches('/[^a-zA-Z0-9]/', '')
            ->lower()
            ->trim()
            ->toString();

        if (empty($exerciseKey)) {
            return null;
        }

        $exercise = $this->exercises->firstWhere('key', $exerciseKey);

        if (!$exercise && !$exerciseName) {
            return null;
        }

        if (!$exercise) {
            $exercise = Exercise::create([
                'key' => $exerciseKey,
                'name' => $exerciseName
            ]);
    
            $this->exercises->push($exercise);
        }

        $exerciseUrl = trim($url);

        if ($exerciseUrl) {
            if (!str_starts_with($exerciseUrl, 'http://')
                && !str_starts_with($exerciseUrl, 'https://')
            ) {
                $exerciseUrl = 'https://' . $exerciseUrl;
            }

            if (!$exercise->exerciseVideos()->where('url', $exerciseUrl)->exists()) {
                $exercise->exerciseVideos()->create(['url' => $exerciseUrl]);
            }
        }

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
        $minWarmUps = preg_match('/\d/', $row['warm_up_sets'], $matches)
            ? (int) $matches[0]
            : null;
        $maxWarmUps = preg_match_all('/\d/', $row['warm_up_sets'], $matches)
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

        $minSets = preg_match('/\d/', $row['sets'], $matches)
            ? (int) $matches[0]
            : null;
        $maxSets = preg_match_all('/\d/', $row['sets'], $matches)
            ? (int) end($matches[0])
            : null;

        if ($maxSets) {
            while ($setOrder <= $maxSets) {
                $reps = $this->getReps($row['reps']);
                $rpe = Str::of($row['rpe'])
                    ->replace('N/A', '')
                    ->trim()
                    ->toString();
                $percent1RM = Str::of($row['percent_one_rep_max'])
                    ->replace(['N/A', '%'], '')
                    ->trim()
                    ->toString();
                $workoutExercise->sets()->create([
                    'order' => $setOrder,
                    'is_optional' => empty($minSets) || $setOrder > $minSets,
                    'min_reps' => $reps[0],
                    'max_reps' => $reps[1],
                    'rpe' => $rpe ?: null,
                    'intensity_technique' => $this->getIntensityTechnique($row['reps']),
                    'percent_one_rep_max' => $percent1RM ?: null
                ]);

                $setOrder++;
            }
        }
    }

    public function getReps(string $reps): array
    {
        if (str_contains($reps, '/')) {
            $parts = explode('/', $reps);
            $reps = (int)$parts[0] + (int)$parts[1];
        }
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
        $intensityTechnique = preg_replace('/[\d\-\(\)\/]/', '', $reps);
        $intensityTechnique = trim($intensityTechnique);

        return empty($intensityTechnique) ? null : strtolower($intensityTechnique);
    }
}
