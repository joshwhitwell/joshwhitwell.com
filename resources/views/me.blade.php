<x-app-layout title="Me">
  <x-slot name="header">
    <h1>Me</h1>
  </x-slot>
  <form action="{{ route('writings.store') }}" method="POST">
    @csrf
    <input id="body" type="hidden" name="body" />
    <trix-editor input="body"></trix-editor>
    <button type="submit">Save</button>
    @if ($errors->any())
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    @endif
  </form>
</x-app-layout>
