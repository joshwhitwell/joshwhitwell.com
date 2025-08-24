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
            <legend>New log</legend>
            <div class="inputs">
                <div>
                    <label for="reps">Reps</label>
                    <input id="reps" name="reps" type="text">

                    <label for="weight">Weight</label>
                    <input id="weight" name="weight" type="text">
                </div>

                <button type="submit">Log</button>
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
            box-sizing: border-box;
            padding: 12px 10px 15px;
        }

        fieldset .inputs {
            display: flex;
            gap: 5px;
        }

        .inputs div {
            align-items: center;
            display: flex;
            gap: 5px;
        }

        .inputs div input {
            width: 100%;
        }
    </style>
</x-layout>
