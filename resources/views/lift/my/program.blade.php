<x-layouts.lift>
  <h1>{{ $programLog->program->name }}</h1>

  @foreach ($programLog->phaseLogs as $phaseLog)
  <h2>{{ $phaseLog->phase->name }}</h2>

  @foreach ($phaseLog->weekLogs as $weekLog)
  <h3>{{ $weekLog->week->name }}</h3>

  @foreach ($weekLog->workoutLogs as $workoutLog)
  <a href="{{ route('lift.my.programs.workouts.edit', ['programLog' => $programLog, 'workoutLog' => $workoutLog]) }}">
    <h4>{{ $workoutLog->workout->name }}</h4>
  </a>
  @endforeach
  @endforeach
  @endforeach
</x-layouts.lift>