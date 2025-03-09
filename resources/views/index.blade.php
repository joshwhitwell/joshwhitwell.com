<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />

  @if (file_exists(public_path('build/manifest.json'))
  || file_exists(public_path('hot'))
  )
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>

<body>
  <div id="app" class="app">
    {{-- app-bar --}}
    <header class="app-bar">
      <div class="app-bar__row">
        <section class="app-bar__section">
          <button class="app-icon-button" onclick="window._toggleAppNavigationDrawer()">
            <span class="material-symbols-outlined">
              menu
            </span>
          </button>
        </section>
      </div>
    </header>

    {{-- navigation-drawer --}}
    <div id="app-navigation-drawer" class="app-navigation-drawer">
      <nav class="app-navigation-drawer__nav">
        <button class="app-icon-button" onclick="window._toggleAppNavigationDrawer()">
          <span class="material-symbols-outlined">
            menu
          </span>
        </button>

        <ol>
          @for ($i = 0; $i < 100; $i++) <li>
            The current value is {{ $i }}
            </li>
            @endfor
        </ol>
      </nav>
    </div>
  </div>
</body>

</html>