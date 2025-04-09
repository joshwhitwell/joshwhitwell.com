<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  @if (file_exists(public_path('build/manifest.json'))
  || file_exists(public_path('hot'))
  )
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>

<body>
  <a href="{{ '/my/programs/' . $programDayLog->lift_program_log_id }}">{{ $programDayLog->programLog->program->name
    }}</a>
  <h1>{{ $programDayLog->workout->name }}</h1>

  @if ($programDayLog->completed_at)
  <div>
    <form action="{{ '/workout-program-day-logs/' . $programDayLog->id }}" method="POST">
      @csrf
      @method('PUT')

      <input type="hidden" id="status" name="status" value="{{ \App\Enums\Lift\LiftStatus::NOT_STARTED }}" />

      <em>Completed on </em> {{ $programDayLog->completed_at->format('M d, Y \a\t g:i A') }}
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
  <form action="{{ '/workout-program-day-logs/' . $programDayLog->id }}" method="POST">
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

  @foreach ($programDayLog->workoutExerciseLogs as $exerciseLog)
  <h2>{{ $exerciseLog->workoutExercise->exercise->name }}</h2>

  @foreach ($exerciseLog->setLogs as $setLog)
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
</body>

</html>