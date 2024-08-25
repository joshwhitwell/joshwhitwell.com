<x-app-layout title="Sources">
  <x-slot name="header">
    <h1>Sources</h1>
  </x-slot>

  <a href="{{ route('my.sources.create') }}" class="button">+ New Source</a>

  @if ($sources->isNotEmpty())
  <ol>
    @foreach ($sources as $source)
    <li>
      <h2 class="flex align-items-center gap-1">
        <a href="{{ route('my.sources.edit', $source) }}"
          >{!! $source->citation !!}
        </a>
      </h2>
      <p>{{ $source->created_at->format('M j, Y') }}</p>
    </li>
    @endforeach
  </ol>
  @endif

  {{ $sources->links() }}
</x-app-layout>
