<?php
$method = $method ?? "post";
?>

<div>
  <form
    {{ $attributes }}
    method="{{ $method }}"
  >
    @if ($method !== "get")
      @csrf
    @endif
    @method($method)

    {{ $slot }}
  </form>
</div>
