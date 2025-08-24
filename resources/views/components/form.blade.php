<?php
    $method = $method ?? 'POST';
?>

<form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}">
    @if($method !== 'GET')
        @csrf
    @endif

    @if(!in_array($method, ['GET', 'POST']))
        @method($method)
    @endif

    {{ $slot }}

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
