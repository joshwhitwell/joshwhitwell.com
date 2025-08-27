<x-layout>
    <a href="{{ route('exercises.index') }}">&larr; Exercises</a>

    <h1>{{ $title }}</h1>

    <x-form
        action="{{ $exercise->exists ? route('exercises.update', $exercise) : route('exercises.store') }}"
        method="{{ $exercise->exists ? 'PUT' : 'POST' }}"
    >
        <x-input
            name="name"
            label="Exercise Name"
            required
            autofocus
            value="{{ old('name', $exercise->name) }}"
        />

        <x-select
            name="muscle_group"
            label="Muscle Group"
            required
            :options="$exercise::getMuscleGroupSelectOptions()"
            value="{{ old('muscle_group', $exercise->muscle_group) }}"
        />

        <x-button>
            {{ $exercise->exists ? 'Update' : 'Create' }}
        </x-button>
    </x-form>

    @if ($exercise->exists)
        <x-form id="delete-form" action="{{ route('exercises.destroy', $exercise) }}" method="DELETE">
            <x-button id="delete-button" type="submit" color="red">Delete</x-button>
            <script>
                document.getElementById('delete-button').addEventListener('click', function (event) {
                    event.preventDefault();

                    if (confirm('Are you sure you want to delete this exercise?')) {
                        this.closest('form').submit();
                    }
                });
            </script>
            <style>
                #delete-form {
                    margin-block-start: 24px;
                }
            </style>
        </x-form>
    @endif
</x-layout>

