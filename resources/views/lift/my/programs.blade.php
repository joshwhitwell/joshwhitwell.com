<x-layouts.lift>

  @foreach ($programLogs as $programLog)
  <div>
    <a href="{{ route('lift.my.programs.show', ['programLog' => $programLog]) }}">
      <h2>{{ $programLog->program->name }}</h2>
    </a>
  </div>
  @endforeach

</x-layouts.lift>