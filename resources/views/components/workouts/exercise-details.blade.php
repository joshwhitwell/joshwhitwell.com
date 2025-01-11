@props(['exercise'])

@if (!empty($exercise['notes'])
    || !empty($exercise['substitution_option_1'])
    || !empty($exercise['substitution_option_2'])
)

    <div class="px-4">

        @if (!empty($exercise['notes']))

            <p class="leading-tight mb-2 text-sm">{{ $exercise['notes'] }}</p>

        @endif

        <x-workouts.exercise-substitutions
            :exercise="$exercise"
        />

    </div>

@endif
