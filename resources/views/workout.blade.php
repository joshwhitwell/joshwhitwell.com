<x-layouts.workout title="Pure Bodybuilding">

    @foreach ($weeks as $week => $workouts)

        <details
            class="mb-8 bg-slate-100 rounded"
        >

            <summary class="list-none text-2xl py-8 px-4">{{ $week }}</summary>

            @foreach ($workouts as $workout => $exercises)

                <details
                    class="mb-6 bg-slate-200 rounded"
                >

                    <summary class="list-none text-xl py-6 px-4">{{ $workout }}</summary>

                    @foreach ($exercises as $exercise)

                        <x-workouts.exercise
                            :exercise="$exercise"
                            :weekIdx="$loop->parent->parent->index"
                            :workoutIdx="$loop->parent->index"
                            :exerciseIdx="$loop->index"
                        />

                    @endforeach

                </details>

            @endforeach

        </details>

    @endforeach
</x-layouts.workout>
