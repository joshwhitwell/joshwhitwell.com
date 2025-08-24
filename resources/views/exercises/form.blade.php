<x-layout>
    <a href="{{ route('exercises.index') }}">&larr; Exercises</a>

    <h1>{{ $title }}</h1>

    <x-form
        action="{{ $exercise->exists ? route('exercises.update', $exercise) : route('exercises.store') }}"
        method="{{ $exercise->exists ? 'PUT' : 'POST' }}"
    >
        <div>
            <label for="name">
                Name
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $exercise->name) }}"
                    required
                    autofocus
                />
            </label>
        </div>

        <div>
            <label for="muscle_group">
                Muscle Group
                <select
                    id="muscle_group"
                    name="muscle_group"
                    required
                >
                    @foreach($exercise::$muscleGroups as $value)
                        <option
                            value="{{ $value }}"
                            {{ old('muscle_group', $exercise->muscle_group) === $value ? 'selected' : '' }}
                        >
                            {{ \Str::ucfirst($value) }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>

        <button type="submit">
            {{ $exercise->exists ? 'Update' : 'Create' }}
        </button>
    </x-form>

    @if ($exercise->exists)
        <x-form action="{{ route('exercises.destroy', $exercise) }}" method="DELETE">
            <button id="delete-button" type="submit">Delete</button>
            <script>
                document.getElementById('delete-button').addEventListener('click', function (event) {
                    event.preventDefault();

                    if (confirm('Are you sure you want to delete this exercise?')) {
                        this.closest('form').submit();
                    }
                });
            </script>
            <style>
                #delete-button {
                    background-color: rgba(255, 0, 0, 0.10);
                    border: 1px solid red;
                    border-radius: 2px;
                    color: red;
                    margin-block-start: 30px;
                }

                #delete-button:hover {
                    background-color: rgba(255, 0, 0, 0.20);
                }
            </style>
        </x-form>
    @endif
</x-layout>

