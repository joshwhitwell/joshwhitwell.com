<div class="x-input">
    @isset($label)
        <label for="{{ $id ?? $name }}">{{ $label }}</label>
    @endisset

    <input
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        data-1p-ignore
        @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
        @if($required ?? false) required @endif
        @if($autofocus ?? false) autofocus @endif
        @if(($type ?? null) === 'number') step="any" @endif
        @isset($value) value="{{ $value }}" @endisset
    >
</div>

<style>
    .x-input {
        align-items: flex-start;
        display: flex;
        flex-direction: column;
    }

    .x-input label {
        color: black;
        margin-block-end: 4px;
    }

    .x-input input {
        border: 1px solid darkgrey;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 16px;
        margin-block-end: 24px;
        min-height: 40px;
        padding: 8px 16px;
        width: 100%;
    }
</style>
