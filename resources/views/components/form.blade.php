<div class="x-form">
  <form id="{{ $id }}" action="{{ $action }}" method="{{ $method }}">
    @if($useCsrf)
    @csrf
    @endif

    @if($methodSpoof)
    @method($methodSpoof)
    @endif

    {{ $slot }}
  </form>
</div>
