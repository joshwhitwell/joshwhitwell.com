@props([
    'isWarmUp' => false,
    'isLastSet' => false,
    'weekIdx',
    'workoutIdx',
    'exerciseIdx',
    'setIdx',
    'exercise'
])

<?php
    $getInputName = fn ($suffix) =>
        implode('_', [
            $weekIdx,
            $workoutIdx,
            $exerciseIdx,
            $isWarmUp ? 'warm_up' : 'set',
            $setIdx,
            $suffix
        ]);
    $repsId = $getInputName('reps');
    $weightId = $getInputName('weight');
?>

<div class="my-4 bg-slate-400 rounded p-4">
    {{ $isWarmUp ? 'Warm-Up' : 'Set' }} {{ $setIdx }}

    @if (!$isWarmUp
        && (!empty($exercise['reps'])
            || !empty($exercise['early_set_rpe'])
            || !empty($exercise['last_set_rep'])
        )
    )

        @if (!$isLastSet && !empty($exercise['early_set_rpe']))

            <small>

                RPE {{ $exercise['early_set_rpe'] }}

            </small>

        @elseif ($isLastSet && !empty($exercise['last_set_rpe']))

            <small>

                RPE {{ $exercise['last_set_rpe'] }}

            </small>

        @endif

        @if (!empty($exercise['reps']))

            <small>

                @if (!empty($exercise['early_set_rpe']) || !empty($exercise['last_set_rpe']))

                    &middot;

                @endif

                {{ $exercise['reps'] }} reps

            </small>

        @endif

    @endif

    @if (!$isWarmUp
        && $isLastSet
        && !empty($exercise['last_set_intensity_technique'])
        && $exercise['last_set_intensity_technique'] !== 'N/A'
    )

        <div>

            <small>

                {{ $exercise['last_set_intensity_technique'] }}

            </small>

        </div>

    @endif

    <div class="grid grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] gap-x-2 mt-2">
        <label
            for="{{ $repsId }}"
            class="text-xs uppercase mb-1"
        >
            Reps
        </label>

        <label
            for="{{ $weightId }}"
            class="text-xs uppercase mb-1"
        >
            Weight
        </label>

        <span></span>

        <input
            type="number"
            id="{{ $repsId }}"
            name="{{ $repsId }}"
            class="bg-white rounded-md min-h-10 px-3 font-mono"
            :value="getFromLocalStorage('{{ $repsId }}')"
            @input="saveToLocalStorage"
        />

        <input
            type="number"
            id="{{ $weightId }}"
            name="{{ $weightId }}"
            class="bg-white rounded-md min-h-10 px-3 font-mono"
            :value="getFromLocalStorage('{{ $weightId }}')"
            @input="saveToLocalStorage"
        />

        <button
            class="border border-white text-white rounded-md min-h-10 min-w-10 bold justify-self-start flex justify-center items-center"
        >
            <span class="sr-only">Rest {{ !empty($exercise['rest']) ? $exercise['rest'] : '~1-2 min' }}</span>

            <x-icon
                id="timer"
                class="w-6 h-6"
            />
        </button>
    </div>
</div>
