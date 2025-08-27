<div class="x-select">
    @isset($label)
        <label for="{{ $id ?? $name }}">{{ $label }}</label>
    @endisset

    <select
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        type="{{ $type ?? 'text' }}"
        data-1p-ignore
        @if($required ?? false) required @endif
        @if($autofocus ?? false) autofocus @endif
    >
        @foreach($options as $option)
            <option
                value="{{ $option['value'] }}"
                @if(isset($value) && $value === $option['value']) selected @endif
            >
                {{ $option['label'] }}
            </option>
        @endforeach
    </select>
</div>

<style>
    .x-select {
        align-items: flex-start;
        display: flex;
        flex-direction: column;
    }

    .x-select label {
        color: black;
        margin-block-end: 4px;
    }

    .x-select select {
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
