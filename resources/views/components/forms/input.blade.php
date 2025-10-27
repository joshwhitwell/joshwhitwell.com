<?php
$hasError = $errors->has($name);
?>

<div class="mb-6 flex flex-col">
  @isset($label)
    <label for="{{ $name }}">{{ $label }}</label>
  @endisset

  @isset($help)
    <p>{{ $help }}</p>
  @endisset

  <input
    class="{{ $hasError ? 'border-orange-300' : 'border-neutral-300' }} border-box min-h-[40px] w-full rounded-sm border border-2 px-2 focus:outline-neutral-600"
    id="{{ $id ?? $name }}"
    name="{{ $name }}"
    type="{{ $type ?? 'text' }}"
  >

  @if ($hasError)
    <p class="text-sm text-orange-400">{{ $errors->first($name) }}</p>
  @endif
</div>
