<?php
$back = $back ?? null;
$title = $title ?? null;
$headTitle = collect([$title, config('app.name', 'Josh Whitwell')])
    ->filter()
    ->implode(' — ');
$lang = str_replace('_', '-', app()->getLocale());
$shouldVite = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
?>

<!DOCTYPE html>
<html lang="{{ $lang }}">

  <head>
    <meta charset="utf-8">
    <meta
      content="width=device-width, initial-scale=1"
      name="viewport"
    >

    <title>{{ $headTitle }}</title>

    {{-- PWA --}}
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
    @if ($shouldVite)
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
  </head>

  <body class="relative bg-neutral-100 text-neutral-900">
    @auth
      <x-app.nav-bar
        :back="$back"
        :title="$title"
      />
    @endauth

    <main class="relative">
      {{ $slot }}
    </main>
  </body>

</html>
