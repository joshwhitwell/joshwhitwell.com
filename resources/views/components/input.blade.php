<div @class([
  'x-input',
  "x-input--$type",
  'x-input--has-error' => $errors->has($name),
])>
  @if ($label)
    <label for="{{ $name }}" class="x-input-label h6">
      {{ $label }}
      @if ($type === 'checkbox')
        <input
          id="{{ $id }}"
          name="{{ $name }}"
          type="{{ $type }}"
          value="{{ $value }}"
          class="x-input-input"
          {{ $checked ? 'checked' : '' }}
          {{ $required ? 'required' : '' }}
          {{ $disabled ? 'disabled' : '' }}
          {{ $autofocus ? 'autofocus' : '' }}
          {{ $placeholder ? 'placeholder=' . $placeholder : '' }}
          {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}
        >
      @endif
    </label>
  @endif

  @if ($helpText)
    <p class="x-input-help">{{ $helpText }}</p>
  @endif

  @switch ($type)
    @case ('richtext')
      <input id="{{ $id }}" name="{{ $name }}" type="hidden" value="{{ $value }}"/>
      <trix-editor input="{{ $id }}"></trix-editor>
    @break

    @case ('textarea')
      <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $placeholder ? 'placeholder=' . $placeholder : '' }}
        {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}
      >{{ $value }}</textarea>
    @break

    @case ('checkbox')
    @break

    @default
      <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        class="x-input-input"
        {{ $checked ? 'checked' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $placeholder ? 'placeholder=' . $placeholder : '' }}
        {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}
      >
  @endswitch

  @error($name)
    <p class="x-input-error">{{ $message }}</p>
  @enderror
</div>
