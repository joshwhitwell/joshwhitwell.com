<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta
      content="width=device-width, initial-scale=1"
      name="viewport"
    >

    <title>{{ config('app.name', 'Josh Whitwell') }}</title>

    <link
      href="/site.webmanifest"
      rel="manifest"
    >

    <!-- Fonts -->
    <link
      href="https://fonts.bunny.net"
      rel="preconnect"
    >
    <link
      href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
      rel="stylesheet"
    />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
  </head>

  <body>
  </body>

</html>
