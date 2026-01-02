<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Josh Whitwell') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  <!-- Styles / Scripts -->
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('vite')
  @endif
</head>

<body @class([
  'bg-stone-100',
  'fill-stone-700',
  'h-screen',
  'p-4',
  'text-stone-700',
  'w-screen',
])>
  <x-ui.account-menu />

  <main @class([
    'h-full',
    'w-full',
  ])>
    {{ $slot }}
  </main>
</body>

</html>
