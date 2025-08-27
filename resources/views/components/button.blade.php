<div class="x-button">
    <button type="{{ $type ?? 'submit' }}" @isset($color) class="button--{{ $color }}" @endisset>
        {{ $slot }}
    </button>
</div>

<style>
    .x-button button {
        background-color: dodgerblue;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        min-height: 40px;
        padding: 8px;
        width: 100%;
    }

    .x-button .button--red {
        background-color: transparent;
        border: 2px solid crimson;
        color: crimson;
    }
</style>
