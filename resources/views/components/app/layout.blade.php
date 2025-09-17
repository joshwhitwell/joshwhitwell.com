<!DOCTYPE html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ (isset($title) ? $title . ' - ' : '') . config('app.name', 'Josh Whitwell') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,200..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css'])
    </head>

    <body>
        <header class="app-header">
            <a href="/" class="app-name">{{ config('app.name') }}</a>

            <nav class="app-nav">
                <a href="{{ route('me') }}">Home</a>
                <a href="{{ route('translations.index') }}">Translations</a>
                <a href="{{ route('logout') }}">Log Out</a>
            </nav>
        </header>

        <main>
            {{ $slot }}
        </main>
</html>
