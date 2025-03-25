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
  <h1>{{ $programLog->workoutProgram->name }}</h1>

  @foreach ($programLog->workoutProgram->workoutProgramPhases as $phase)
    <h2>{{ $phase->name }}</h2>

    @foreach ($phase->workoutProgramWeeks as $week)
      <h3>{{ $week->name }}</h3>

      @foreach ($week->workoutProgramDays as $day)
        <a href="{{ '/my/programs/' . $programLog->id . '/days/' . $day->workout_program_day_log_id }}"><h4>{{ $day->name }}</h4></a>

      @endforeach
    @endforeach
  @endforeach
</body>

</html>
