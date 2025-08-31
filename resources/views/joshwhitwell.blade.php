<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Josh Whitwell') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,200..800&display=swap" rel="stylesheet">

        @vite(['resources/css/joshwhitwell.css', 'resources/js/joshwhitwell.js'])
    </head>

    <body>
        <main>
            <h1>Josh Whitwell</h1>

            @foreach ([
                'landscape' => 'joshwhitwell',
                'portrait' => 'jwwohesilhtl'
            ] as $orientation => $letters)
                <div aria-hidden="true" class="fullscreen fullscreen--{{ $orientation }}">
                    <div class="letters">
                        @foreach (str_split($letters) as $letter)
                            <div class="letter" style="opacity: 0;">{{ $letter }}</div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </main>
    </body>
</html>
