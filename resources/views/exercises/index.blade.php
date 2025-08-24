@use('App\Models\Exercise', 'Exercise')

<x-layout>
    <header>
        <h1>Exercises</h1>
        <a href="{{ route('exercises.create') }}">+ Add Exercise</a>
    </header>

    <details>
        <summary>
            <strong>Filter</strong>
        </summary>

        <x-form action="{{ route('exercises.index') }}" method="GET">
            @if(request()->has('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

            <input
                id="filter[search]"
                name="filter[search]"
                type="search"
                placeholder="Search by name"
                value="{{ request()->input('filter.search') }}"
            >

            <div>
                <h3>Muscle</h3>

                @foreach(Exercise::$muscleGroups as $group)
                    <div>
                        <input
                            type="checkbox"
                            id="filter[muscle_group][{{ $group }}]"
                            name="filter[muscle_group][]"
                            value="{{ $group }}"
                            {{ in_array($group, (array) request()->input('filter.muscle_group', [])) ? 'checked' : '' }}
                        >
                        <label for="filter[muscle_group][{{ $group }}]">{{ \Str::ucfirst($group) }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit">Apply</button>

            @if(request()->has('filter'))
                <a href="{{ route('exercises.index', request()->except('filter')) }}">Clear</a>
            @endif
        </x-form>
    </details>

    <table>
        <thead>
            <tr>
                <th>
                    Name
                    <x-sort route-name="exercises.index" sort-name="name"/>
                </th>
                <th>
                    Muscle
                    <x-sort route-name="exercises.index" sort-name="muscle_group"/>
                </th>
                <th>
                    Last Logged
                    <x-sort route-name="exercises.index" sort-name="last_logged_at"/>
                </th>
                <th>
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>

        <tbody>
            @forelse ($exercises as $exercise)
                <tr>
                    <td>
                        <a href="{{ route('exercises.show', $exercise) }}">{{ $exercise->name }}</a>
                    </td>
                    <td>
                        {{ \Str::ucfirst($exercise->muscle_group) }}
                    </td>
                    <td>
                        {{ $exercise->last_logged_at?->diffForHumans() }}
                    </td>
                    <td>
                        <a href="{{ route('exercises.edit', $exercise) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        <em>No results</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <style>
        header {
            align-items: center;
            display: flex;
            justify-content: space-between;
        }

        details h3 {
            margin-block: 0 10px;
        }

        details form {
            margin-block-end: 20px;
        }

        details input[type='search'] {
            margin-block-end: 10px;
        }

        details button {
            margin-block-start: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        th, td {
            padding: 10px;
        }

        thead {
            border: 1px solid black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</x-layout>
