<x-layouts.lift>
  <a href="{{ route('lift.my.programs.show', $programLog) }}">
    {{ $programLog->program->name}}
  </a>

  <h1>{{ $workoutLog->workout->name }}</h1>
  
  @if ($workoutLog->completed_at)
    <x-forms.form action="{{ $updateWorkoutRoute }}" method="PUT">
      <input type="hidden" id="status" name="status" value="{{ $liftStatus::NotStarted }}" />

      <em>Completed on </em> {{ $workoutLog->completed_at->format('M d, Y \a\t g:i A') }}

      <button type="submit">Undo</button>
    </x-forms.form>
  @else
    <x-forms.form action="{{ $updateWorkoutRoute }}" method="PUT">
      <input type="hidden" id="status" name="status" value="{{ $liftStatus::Completed }}" />

      <button type="submit">Mark Complete</button>
    </x-forms.form>
  @endif

  @foreach ($workoutLog->workoutExerciseLogs as $workoutExerciseLog)
    <h2>{{ $workoutExerciseLog->workoutExercise->exercise->name }}</h2>

    @foreach ($workoutExerciseLog->setLogs as $setLog)
      <h3>
        {{ $setLog->set->is_warm_up ? 'Warm Up' : 'Set' }} {{ $setLog->set->order }}

        @if ($setLog->set->is_optional)
          <small>(Optional)</small>
        @endif
      </h3>

      <x-forms.form action="{{ route('lift.set-logs.update', $setLog) }}" method="PUT">
        <x-forms.input
          name="reps_{{ $setLog->id }}"
          label="Reps"
          value="{{ $setLog->reps }}"
        />

        <x-forms.input
          name="weight_{{ $setLog->id }}"
          label="Weight"
          value="{{ $setLog->weight }}"
        />

        <button type="submit">Save</button>
      </x-forms.form>
    @endforeach
  @endforeach
</x-layouts.lift>