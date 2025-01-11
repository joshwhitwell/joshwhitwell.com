@props(['exercise', 'weekIdx', 'workoutIdx', 'exerciseIdx'])

<details
    class="mb-4 group bg-slate-300 rounded"
>

    <summary
        class="list-none text-lg flex items-center px-4 pt-4 pb-4 group-open:pb-0"
    >

        {{ $exercise['exercise'] ?? '' }}

        @if (!empty($exercise['exercise_link']))

            <a
                href="{{ $exercise['exercise_link'] }}"
                target="_blank"
                class="text-blue-600 underline text-sm group-open:inline hidden px-2"
            >
                Watch
            </a>

        @endif

    </summary>

    <x-workouts.exercise-details
        :exercise="$exercise"
    />

    @for ($i = 1; $i <= $exercise['warm_up_sets']; $i++)

        <x-workouts.exercise-set
            :weekIdx="$weekIdx"
            :workoutIdx="$workoutIdx"
            :exerciseIdx="$exerciseIdx"
            :setIdx="$i"
            :isWarmUp="true"
            rest="~1-2 min"
        />

    @endfor

    @for ($i = 1; $i <= $exercise['working_sets']; $i++)

        <x-workouts.exercise-set
            :weekIdx="$weekIdx"
            :workoutIdx="$workoutIdx"
            :exerciseIdx="$exerciseIdx"
            :setIdx="$i"
            :rest="$exercise['rest'] ?? null"
        />

    @endfor

</details>
