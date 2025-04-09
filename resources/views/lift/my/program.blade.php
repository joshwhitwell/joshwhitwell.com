<x-layouts.lift>
  <h1>{{ $programLog->program->name }}</h1>

  @foreach ($programLog->program->phases as $phase)
  <h2>{{ $phase->name }}</h2>

  @foreach ($phase->weeks as $week)
  <h3>{{ $week->name }}</h3>

  @foreach ($week->workouts as $day)
  <a href="{{ '/my/programs/' . $programLog->id . '/days/' . $day->workout_log_id }}">
    <h4>{{ $day->name }}</h4>
  </a>
  @endforeach
  @endforeach
  @endforeach
</x-layouts.lift>