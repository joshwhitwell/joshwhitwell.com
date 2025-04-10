<x-layouts.lift>
  <a href="{{ route('lift.my.programs.show', $programLog) }}">
    {{ $programLog->program->name}}
  </a>

  <h1>{{ $workoutLog->workout->name }}</h1>

  @if ($workoutLog->completed_at)
  <div>
    <form action="{{ '/workout-program-day-logs/' . $workoutLog->id }}" method="POST">
      @csrf
      @method('PUT')

      <input type="hidden" id="status" name="status" value="{{ \App\Enums\Lift\LiftStatus::NOT_STARTED }}" />

      <em>Completed on </em> {{ $workoutLog->completed_at->format('M d, Y \a\t g:i A') }}
      <button>Undo</button>

      @if ($errors->any())
      <div>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
    </form>
  </div>
  @else
  <form action="{{ '/workout-program-day-logs/' . $workoutLog->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" id="status" name="status" value="{{ \App\Enums\Lift\LiftStatus::COMPLETED }}" />

    <button>Mark Complete</button>

    @if ($errors->any())
    <div">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
      </div>
      @endif
  </form>
  @endif

  @foreach ($workoutLog->workoutExerciseLogs as $workoutExerciseLog)
  <h2>{{ $workoutExerciseLog->workoutExercise->exercise->name }}</h2>

  @foreach ($workoutExerciseLog->setLogs as $setLog)
  <h3>
    {{ $setLog->set->is_warm_up ? 'Warm Up' : 'Set' }} {{
    $setLog->set->order }}
    @if ($setLog->set->is_optional)
    <small>(Optional)</small>
    @endif
  </h3>

  <div>
    <form action="{{ route('set-logs.update', $setLog) }}" method="POST">
      @csrf
      @method('PUT')

      <label for="reps">
        Reps
        <input type="text" name="reps" value="{{ $setLog->reps ?? null }}">
      </label>

      <label for="weight">
        Weight
        <input type="text" name="weight" value="{{ $setLog->weight ?? null }}">
      </label>

      <button>Save</button>
    </form>
  </div>
  @endforeach
  @endforeach
</x-layouts.lift>