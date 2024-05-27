<x-app-layout title="{{ $pageTitle }}">
  <x-slot name="header">
    <h1>{{ $writing->internalTitle }}</h1>
  </x-slot>

  <x-form
    :action="$formAction"
    :method="$formMethod"
    :submit-button-text="$submitButtonText"
  >
    <x-input
      name="title"
      label="Title"
      :value="old('title') ?? $writing->title"
      :autofocus="true"
    />

    <x-input
      name="body"
      label="Body"
      type="richtext"
      :value="old('body') ?? $writing->body"
    />

    <x-input
      name="written_at"
      label="Written At"
      type="date"
      :value="old('written_at') ?? $writing->written_at"
    />

    <x-input
      name="visibility"
      label="Visible?"
      type="checkbox"
      value="1"
      :checked="
        old('visibility') !== null
          ? (bool) old('visibility')
          : (bool) $writing->visibility
      "
    />
  </x-form>

  @if ($writing->exists)
    <x-form
      :action="route('my.writings.destroy', $writing)"
      method="DELETE"
    >
      <x-slot:buttons>
        <button type="submit" onclick="
          event.preventDefault();
          if (confirm('Are you sure you want to delete this writing?')) {
            this.closest('form').submit();
          }
        ">Delete</button>
      </x-slot>
    </x-form>
  @endif
</x-app-layout>
