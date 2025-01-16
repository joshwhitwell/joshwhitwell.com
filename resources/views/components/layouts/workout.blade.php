@props(['title'])

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    />

    @if (!empty($title))
        <title>{{ $title }}</title>
    @endif

    <!-- Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    />
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
</head>

<body class="p-4 text-black bg-white max-w-prose mx-auto box-border" x-data="workoutApp()">
    {{ $slot }}
</body>

<script>
    function workoutApp() {
        return {
            getFromLocalStorage(key) {
                return window.localStorage.getItem(key);
            },
            saveToLocalStorage(e) {
                const key = e?.target?.id;
                const value = e?.target?.value;

                if (key) {
                    window.localStorage.setItem(key, value);
                }
            },
            getPlaceholder(key) {
                return window.localStorage.getItem(key);
            },
        };
    }
</script>

</html>
