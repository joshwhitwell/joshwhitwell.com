<x-app-layout title="My Writings">

  <x-slot name="header">
    <h1>My Writings</h1>
  </x-slot>

  <a href="{{ route('my.writings.create') }}">+ New Writing</a>

  @if ($writings->isNotEmpty())
    <ol>
      @foreach ($writings as $writing)
        <li>
          <h2>
            <a href="{{ route('my.writings.edit', $writing) }}">{{ $writing->internalTitle }}</a>
          </h2>
          <p>{{ $writing->created_at->format('M j, Y') }}</p>
          {!! $writing->body !!}
        </li>
      @endforeach
    </ol>
  @endif

  {{ $writings->links() }}

</x-app-layout>
