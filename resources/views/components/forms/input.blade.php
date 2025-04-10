<div>
  <label for="{{ $id ?? $name }}">
    {{ $label ?? '' }}

    <input
      id="{{ $id ?? $name }}"
      name="{{ $name }}"
      type="{{ $type ?? 'text' }}"
      value="{{ $value ?? null }}"
    >
  </label>

  @if ($errors->has($name))
    <ul>
      @foreach ($errors->get($name) as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif
</div>