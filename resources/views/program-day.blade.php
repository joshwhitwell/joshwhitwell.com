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
  <a href="{{ '/my/programs/' . $programDayLog->workout_program_log_id }}">{{ $programDayLog->workoutProgramLog->workoutProgram->name }}</a>
  <h1>{{ $programDayLog->workoutProgramDay->name }}</h1>

  @if ($programDayLog->completed_at)
    <div>
      <form action="{{ '/workout-program-day-logs/' . $programDayLog->id }}" method="POST">
        @csrf
        @method('PUT')
  
        <input type="hidden" id="status" name="status" value="{{ \App\Enums\WorkoutProgramStatus::NOT_STARTED }}" />
  
        <em>Completed on </em> {{ $programDayLog->completed_at->format('M d, Y \a\t g:i A') }}
        <button>Undo</button>
  
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
    </div>
  @else
    <form action="{{ '/workout-program-day-logs/' . $programDayLog->id }}" method="POST">
      @csrf
      @method('PUT')

      <input type="hidden" id="status" name="status" value="{{ \App\Enums\WorkoutProgramStatus::COMPLETED }}" />

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

  @foreach ($programDayLog->workoutProgramDayExerciseLogs as $exerciseLog)
    <h2>{{ $exerciseLog->workoutProgramDayExercise->exercise->name }}</h2>

    @foreach ($exerciseLog->workoutProgramDayExerciseSetLogs as $setLog)
      <h3>
        {{ $setLog->workoutProgramDayExerciseSet->is_warm_up ? 'Warm Up' : 'Set' }} {{ $setLog->workoutProgramDayExerciseSet->order }}
        @if ($setLog->workoutProgramDayExerciseSet->is_optional)
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
