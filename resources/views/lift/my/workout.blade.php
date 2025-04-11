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

    @php

    @endphp

    @if (!empty($workoutExerciseLog->pastLogs))
      <details>
        <summary>History</summary>

        <table style="text-align: left;">
          <thead>
            <tr>
            <th>Set</th>
            <th style="text-align: right;">Reps</th>
            <th style="text-align: right;">Weight</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($workoutExerciseLog->pastLogs as $pastLog)
              @if ($loop->index > 0)
                <tr><td colspan="3"></td></tr>
              @endif

              @foreach ($pastLog->setLogs as $setLog)
                <tr>
                  <td>{{ $setLog->set->is_warm_up ? 'Warm Up' : 'Set' }} {{ $setLog->set->order }}</td>
                  <td style="text-align: right;">{{ $setLog->reps ?? '-' }}</td>
                  <td style="text-align: right;">{{ $setLog->weight ?? '-' }}</td>
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </details>
    @endif

    @foreach ($workoutExerciseLog->setLogs as $setLog)
      <h3>
        {{ $setLog->set->is_warm_up ? 'Warm Up' : 'Set' }} {{ $setLog->set->order }}

        @if ($setLog->set->is_optional)
        <small>(Optional)</small>
        @endif
      </h3>

      <x-forms.form action="{{ route('lift.set-logs.update', $setLog) }}" method="PUT">
        <x-forms.input
          id="reps_{{ $setLog->id }}"
          name="reps"
          label="Reps"
          value="{{ $setLog->reps }}"
        />

        <x-forms.input
          id="weight_{{ $setLog->id }}"
          name="weight"
          label="Weight"
          value="{{ $setLog->weight }}"
        />

        <button type="submit">Save</button>
      </x-forms.form>
    @endforeach
  @endforeach
</x-layouts.lift>
