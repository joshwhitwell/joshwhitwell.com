@props(['headTitle', 'breadcrumbs'])

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $headTitle ?? config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body>

        <header class="bg-gray-900 text-white p-4 min-h-[56px]">

            <?php
                $back = $breadcrumbs[count($breadcrumbs) - 2] ?? null;
            ?>

            @if ($back)

                <a href="{{ $back['route'] }}">
                    &larr;
                    <span class="ml-1">{{ $back['name'] }}</span>
                </a>

            @else

                <a href="/">
                    <span class="ml-1">Home</span>
                </a>

            @endif

        </header>


        <main class="px-4">

            {{ $slot }}

        </main>

    </body>

</html>
