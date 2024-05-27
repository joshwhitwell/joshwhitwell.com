<div>
  @if ($label)
    <label for="{{ $name }}">{{ $label }}</label>
  @endif

  @if ($helpText)
    <p>{{ $helpText }}</p>
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

    @default
      <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $placeholder ? 'placeholder=' . $placeholder : '' }}
        {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}
      >
  @endswitch

  @error($name)
    <div>{{ $message }}</div>
  @enderror
</div>
