<x-layout>
    <a href="{{ route('exercises.index') }}">&larr; Exercises</a>

    <h1>{{ $exercise->name }}</h1>

    <h2>
        Last logged:
        @if ($lastLoggedAt)
            {{ $lastLoggedAt->format('M d, Y') }}
        @else
            <em>never</em>
        @endif
    </h2>

    @if($stats && count($stats) > 0)
        <details>
            <summary>Personal Records</summary>

            <table>
                <thead>
                    <tr>
                        <th class="sr-only">Reps</th>
                        <th class="sr-only">Weight</th>
                        <th class="sr-only">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats as $stat)
                        <tr>
                            <td><strong>{{ $stat['reps'] }} rep{{ $stat['reps'] === 1 ? '' : 's' }}</strong></td>
                            <td>{{ $stat['weight'] }} {{ $stat['weight'] === 1 ? 'lb' : 'lbs' }}</td>
                            <td>{{ $stat['date']->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </details>
    @endif

    <x-form action="{{ route('exercises.exercise-logs.store', $exercise) }}">
        <fieldset>
            <legend>Log a set</legend>
            <div class="inputs">
                <div>
                    <x-input name="reps" label="Reps" type="number" />
                    <x-input name="weight" label="Weight" type="number" />
                </div>

                <x-button>Log</x-button>
            </div>
        </fieldset>
    </x-form>

    @if($exercise->exerciseLogs->isNotEmpty())
        <h2>Past Logs</h2>
        <ul>
            @foreach($exercise->exerciseLogs as $exerciseLog)
                <li>
                    <strong>{{ $exerciseLog->created_at->format('M j, Y') }}</strong>:
                    {{ $exerciseLog->reps }} {{ $exerciseLog->reps === 1 ? 'rep' : 'reps' }}
                    x
                    {{ $exerciseLog->weight }} lbs
                </li>
            @endforeach
        </ul>

        {{ $exerciseLogs->links() }}
    @else
        <p>
            <em>No logged data</em>
        </p>
    @endif

    <style>
        details table {
            margin-block-end: 20px;
        }

        th, td {
            padding: 2.5px 10px;
        }

        tbody tr:last-of-type td {
            padding-block-end: 0;
        }

        fieldset {
            border-radius: 8px;
            border: 1px solid lightgrey;
            padding-block: 16px;
        }

        fieldset legend {
            font-size: 20px;
            font-weight: 600;
        }
    </style>
</x-layout>
