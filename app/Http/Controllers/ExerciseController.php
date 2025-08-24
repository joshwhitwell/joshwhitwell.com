<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = QueryBuilder::for(Exercise::class)
            ->select('exercises.*')
            ->selectSub(function ($query) {
                $query->select('created_at')
                    ->from('exercise_logs')
                    ->whereColumn('exercise_id', 'exercises.id')
                    ->latest()
                    ->limit(1);
            }, 'last_logged_at')
            ->withCasts(['last_logged_at' => 'datetime'])
            ->allowedSorts(['name', 'muscle_group', 'last_logged_at'])
            ->defaultSort('last_logged_at', 'name')
            ->allowedFilters([
                'muscle_group',
                AllowedFilter::callback('search', function ($query, $search) {
                    $query->where('name', 'like', "%$search%");
                })
            ])
            ->get();

        return view('exercises.index', [
            'exercises' => $exercises
        ]);
    }

    public function create()
    {
        return view('exercises.form', [
            'title' => 'New Exercise',
            'exercise' => new Exercise
        ]);
    }

    public function store(StoreExerciseRequest $request)
    {
        Exercise::create($request->validated());

        return to_route('exercises.index');
    }

    public function show(Exercise $exercise)
    {
        $stats = [];

        for ($reps = 1; $reps <= 15; $reps++) {
            $maxLog = $exercise->exerciseLogs()
                ->where('reps', $reps)
                ->orderByDesc('weight')
                ->first();

            if ($maxLog) {
                $stats[$reps] = [
                    'reps' => $reps,
                    'weight' => $maxLog?->weight,
                    'date' => $maxLog?->created_at,
                ];
            }
        }

        return view('exercises.show', [
            'exercise' => $exercise,
            'exerciseLogs' => $exercise->exerciseLogs()->orderByDesc('created_at')->paginate(100),
            'lastLoggedAt' => $exercise->exerciseLogs->first()?->created_at,
            'stats' => $stats,
        ]);
    }

    public function edit(Exercise $exercise)
    {
        return view('exercises.form', [
            'title' => $exercise->name,
            'exercise' => $exercise
        ]);
    }

    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->validated());

        return to_route('exercises.index');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return to_route('exercises.index');
    }
}
