<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />

  @if (file_exists(public_path('build/manifest.json'))
  || file_exists(public_path('hot'))
  )
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>

<body>
  {{-- <h1>{{ $program->name }}</h1>

  @foreach ($program->workoutProgramPhases as $phase)
  <h2>{{ $phase->name }}</h2>

  @foreach ($phase->workoutProgramWeeks as $week)
  <h3>{{ $week->name }}</h3>

  @foreach ($week->workoutProgramDays as $day)
  <h4>{{ $day->name }}</h4>

  @foreach ($day->workoutProgramDayExercises as $exercise)
  <h5>{{ $exercise->exercise->name }}</h5>

  @foreach (['substitutionOne', 'substitutionTwo', 'rest_string', 'notes'] as $attr)
  @if (!empty($exercise->{$attr}))
  <div>{{ $exercise->{$attr}->name ?? $exercise->{$attr} }}</div>
  @endif
  @endforeach

  @foreach ($exercise->workoutProgramDayExerciseSets as $set)
  <h6>
    {{ $set->is_warm_up ? 'Warm Up' : 'Set' }} {{ $set->order }}
    @if ($set->is_optional)
    <small>(Optional)</small>
    @endif
  </h6>

  @if (!empty($set->intensity_technique))
  <div>{{ $set->intensity_technique }}</div>
  @endif

  @if (!empty($set->rpe))
  <div>RPE: {{ $set->rpe }}</div>
  @endif

  @if (!empty($set->rep_string))
  <div>{{ $set->rep_string }}</div>
  @endif

  <div>
    <form action="{{ route('set-logs.store', $set) }}" method="POST">
      @csrf
      <label for="reps">
        Reps
        <input type="text" name="reps" value="{{ $set->log->reps ?? null }}">
      </label>
      <label for="weight">
        Weight
        <input type="text" name="weight" value="{{ $set->log->weight ?? null }}">
      </label>
      <button>Save</button>
    </form>
  </div>
  @endforeach

  @endforeach
  @endforeach
  @endforeach
  @endforeach --}}

  {{-- <form id='workout_log_form' action="{{ route('workout-logs.store') }}" method="POST">
    @csrf
    <input type='hidden' id="user_id" name="user_id" value="1" />

    <div class="input--outlined">
      <select name="workout_id" id="workout_id">
        @foreach (\App\Models\Workout::orderBy('name')->get() as $workout)
        <option value="{{ $workout->id }}">{{ $workout->name }}</option>
        @endforeach
      </select>
      <label for="exercise_id" class="label">Workout</label>
    </div>

    @for ($exerciseNumber = 1; $exerciseNumber <= 7; $exerciseNumber++) <div class="input--outlined">
      <select name="exercises[{{$exerciseNumber}}][id]" id="exercises[{{$exerciseNumber}}][id]">
        @foreach (\App\Models\Exercise::orderBy('name')->get() as $exercise)
        <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
        @endforeach
      </select>
      <label for="exercises[{{$exerciseNumber}}][id]" class="label">Exercise</label>
      </div>

      @for ($set = 1; $set <= 3; $set++) <div class='input-row'>
        @foreach (['reps' => 'Reps', 'weight' => 'Weight', 'duration' => 'Duration'] as $key => $label)
        <div class="input--outlined">
          <input type="number" id="exercises[{{$exerciseNumber}}][sets][{{$set}}][{{$key}}]"
            name="exercises[{{$exerciseNumber}}][sets][{{$set}}][{{$key}}]">
          <label for="exercises[{{$exerciseNumber}}][sets][{{$set}}][{{$key}}]" class="label">{{ $label }}</label>
        </div>
        @endforeach

        </div>

        @endfor
        @endfor

        <button type="submit">Save</button>

        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
  </form> --}}
</body>

    {{-- navigation-drawer --}}
    <div id="app-navigation-drawer" class="app-navigation-drawer">
      <nav class="app-navigation-drawer__nav">
        <button class="app-icon-button" onclick="window._toggleAppNavigationDrawer()">
          <span class="material-symbols-outlined">
            menu
          </span>
        </button>


<style>
  /* :root {
    --border-color: lightgray;
    --border-radius: 4px;
  }

  input,
  select {
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 12px 16px;
  }

  .input-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
    column-gap: 8px;
  }

  .input--outlined {
    display: flex;
    flex-direction: column;

    .label {
      font-size: 12px;
      background-color: white;
      transform: translateY(-49px);
      padding: 0 4px;
      margin-left: 12px;
      width: fit-content;
    }
  } */
</style>
