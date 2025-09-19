<?php
    $method = $method ?? 'post';
?>

<form
    action="{{ $action }}"
    method="{{ $method === 'get' ? 'get' : 'post' }}"
>
    @if($method !== 'get')
        @csrf
    @endif

    @if(!in_array($method, ['get', 'post']))
        @method($method)
    @endif

    {{ $slot }}
</form>
