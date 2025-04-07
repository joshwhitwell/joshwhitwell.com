<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name') }}</title>

  @if (file_exists(public_path('build/manifest.json'))
  || file_exists(public_path('hot'))
  )
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>

<body>
  <div class="login-form">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autofocus>
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div>
        <button type="submit">Login</button>
      </div>
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
  </div>
</body>

</html>