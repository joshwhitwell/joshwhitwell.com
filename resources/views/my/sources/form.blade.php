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
      name="body"
      label="Body"
      type="richtext"
      help-text="The content of the source."
      :value="old('body') ?? $source->body"
    />

    <x-input
      name="publisher_name"
      label="Publisher Name"
      help-text="The publisher of the source."
      :value="old('publisher_name') ?? $source->publisher_name"
    />

    <x-input
      name="publisher_location"
      label="Publisher Location"
      help-text="The location where the source was published."
      :value="old('publisher_location') ?? $source->publisher_location"
    />

    <x-input
      name="publisher_year"
      label="Publisher Year"
      help-text="The year the source was published."
      :value="old('publisher_year') ?? $source->publisher_year"
    />

    <x-input
      name="pages"
      label="Pages"
      help-text="The page range of the source."
      :value="old('pages') ?? $source->pages"
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

    <x-input
      name="visibility"
      label="Visible?"
      type="checkbox"
      value="1"
      :checked="
      old('visibility') !== null
        ? (bool) old('visibility')
        : (bool) $source->visibility
    "
    />
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
