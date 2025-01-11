@props([
    'isWarmUp' => false,
    'weekIdx',
    'workoutIdx',
    'exerciseIdx',
    'setIdx',
    'rest' => null,
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
?>

<div class="my-4 bg-slate-400 rounded p-4">
    {{ $isWarmUp ? 'Warm-Up' : 'Set' }} {{ $setIdx }}

    <div class="grid grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] gap-x-2 mt-2">
        <label
            for="{{ $getInputName('reps') }}"
            class="text-xs uppercase mb-1"
        >
            Reps
        </label>

        <label
            for="{{ $getInputName('weight') }}"
            class="text-xs uppercase mb-1"
        >
            Weight
        </label>

        <span></span>

        <input
            type="number"
            id="{{ $getInputName('reps') }}"
            name="{{ $getInputName('reps') }}"
            class="bg-white rounded-md min-h-10 px-3 font-mono"
        />

        <input
            type="number"
            id="{{ $getInputName('weight') }}"
            name="{{ $getInputName('weight') }}"
            class="bg-white rounded-md min-h-10 px-3 font-mono"
        />

        @if ($rest)
            <button
                class="border border-white text-white rounded-md min-h-10 min-w-10 bold justify-self-start flex justify-center items-center"
            >
                <span class="sr-only">Rest {{ $rest }}</span>

                <x-icon
                    id="timer"
                    class="w-6 h-6"
                />
            </button>
        @endif
    </div>
</div>
