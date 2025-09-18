<?php
    $id = $id ?? $name;
    $type = $type ?? 'text';
    $value = $value ?? null;
?>

<div class="app-input">
    @isset($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endisset

    @isset($help)
        <p class="app-input__help">{{ $help }}</p>
    @endisset

    @if ($type === 'textarea')
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
            @isset($required) required @endisset
            @isset($autofocus) autofocus @endisset
            data-1p-ignore
        >{{ $value }}</textarea>
    @else
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
            @isset($required) required @endisset
            @isset($autofocus) autofocus @endisset
            @if($type === 'number') step="any" @endif
            value="{{ $value }}"
            data-1p-ignore
        >
    @endif
</div>
