<div class="x-input {{ $errorMessage ? 'x-input--has-error' : '' }}">
  @if ($label)
  <label for="{{ $name }}">{{ $label }}</label>
  @endif

  @if ($helpText)
  <p class="x-input__help-text">{{ $helpText }}</p>
  @endif

  <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" @if($autocomplete) autocomplete="{{ $autocomplete }}"
    @endif @if($autofocus) autofocus @endif @if($required) required @endif @if($data1pIgnore) data-1p-ignore @endif
    value="{{ $value }}">

  @if($errorMessage)
  <p class="x-input__error-message">{{ $errorMessage }}</p>
  @endif
</div>
