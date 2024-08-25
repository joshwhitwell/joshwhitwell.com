<x-app-layout title="{{ $pageTitle }}">
  <x-slot name="header">
    <h1>{{ $source->internalTitle }}</h1>
  </x-slot>

  <x-form
    :action="$formAction"
    :method="$formMethod"
    :submit-button-text="$submitButtonText"
  >
    <x-input
      name="source_title"
      label="Source Title"
      help-text="The title of the source."
      :value="old('source_title') ?? $source->source_title"
      :autofocus="true"
    />

    <x-input
      name="section_title"
      label="Section Title"
      help-text="The title of the chapter or section of the source."
      :value="old('section_title') ?? $source->section_title"
    />

    <x-input
      name="publisher"
      label="Publisher"
      help-text="The publisher of the source."
      :value="old('publisher') ?? $source->publisher"
    />

    <x-input
      name="publisher_place"
      label="Publisher Place"
      help-text="The place where the source was published."
      :value="old('publisher_place') ?? $source->publisher_place"
    />

    <x-input
      name="publication_year"
      label="Publication Year"
      help-text="The year the source was published."
      :value="old('publication_year') ?? $source->publication_year"
    />

    <div class="x-form-repeatable">
      <div class="x-input-label h6">Contributors</div>
      <div class="x-input-help">The contributors to the source.</div>

      @foreach (($source->contributors ?? []) as $i => $contributor)
      <div class="x-form-row">
        <x-input
          name="contributors[{{ $i }}][type]"
          type="select"
          :options="$source::$contributorTypes"
          :value="old('contributors[{{ $i }}][type]') ?? $contributor['type']"
        />
        <x-input
          name="contributors[{{ $i }}][first_name]"
          :value="old('contributors[{{
            $i
          }}][first_name]') ?? $contributor['first_name']"
        />
        <x-input
          name="contributors[{{ $i }}][last_name]"
          :value="old('contributors[{{
            $i
          }}][last_name]') ?? $contributor['last_name']"
        />
      </div>
      @endforeach

      <div class="x-form-row">
        <x-input
          name="contributors[new][type]"
          type="select"
          :options="$source::$contributorTypes"
          :allow-null="false"
          :value="old('contributors[new][type]')"
        />
        <x-input
          name="contributors[new][first_name]"
          :value="old('contributors[new][first_name]')"
        />
        <x-input
          name="contributors[new][last_name]"
          :value="old('contributors[new][last_name]')"
        />
      </div>
    </div>
  </x-form>

  @if ($source->exists)
  <x-form :action="route('my.sources.destroy', $source)" method="DELETE">
    <x-slot:buttons>
      <button
        type="submit"
        onclick="
          event.preventDefault();
          if (confirm('Are you sure you want to delete this source?')) {
            this.closest('form').submit();
          }
        "
      >
        Delete
      </button>
    </x-slot:buttons>
  </x-form>
  @endif
</x-app-layout>
