<form action="{{ $action }}" method="POST">
  @csrf
  @method($method)

  {{ $slot }}

  @if (!empty($buttons) && $buttons->hasActualContent())
    {{ $buttons }}
  @else
    <button type="submit" class="x-form-button h6">{{ $submitButtonText }}</button>
  @endif
</form>
