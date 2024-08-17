<x-app-layout title="Writings">
  <x-slot name="header">
    <h1>Writings</h1>
  </x-slot>

  <a href="{{ route('my.writings.create') }}" class="button">+ New Writing</a>

  @if ($writings->isNotEmpty())
  <ol>
    @foreach ($writings as $writing)
    <li>
      <h2 class="flex align-items-center gap-1">
        <a href="{{ route('my.writings.edit', $writing) }}"
          >{{ $writing->internalTitle }}
        </a>
        @if (!$writing->visibility)
        <div class="body pill-tag pill-tag--red">Private</div>
        @endif
      </h2>
      <p>{{ $writing->created_at->format('M j, Y') }}</p>
      {!! $writing->body !!}
    </li>
    @endforeach
  </ol>
  @endif

  {{ $writings->links() }}
</x-app-layout>
