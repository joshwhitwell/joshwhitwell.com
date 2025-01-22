@props(['breadcrumbs'])

<?php
    $back = $breadcrumbs[count($breadcrumbs) - 2] ?? null;
?>

@if ($back)

    <a href="{{ $back['route'] }}" class="text-blue-500">{{ $back['name'] }}</a>

@endif
