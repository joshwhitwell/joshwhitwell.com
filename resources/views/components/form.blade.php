<form action="{{ $action }}" method="POST">
  @csrf
  @method($method)

  {{ $slot }}

  @if (!empty($buttons) && $buttons->hasActualContent())
    {{ $buttons }}
  @else
    <button type="submit">{{ $submitButtonText }}</button>
  @endif
</form>
