<form action="{{ $action }}" method="POST">
  @csrf
  @method($method ?? 'POST')

  {{ $slot }}
</form>