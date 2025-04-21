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
  <div class="page">
    <h1 class="page-title">Log In</h1>

    <form method="POST" action="{{ route('login') }}" class="login-form">
      @csrf
  
      <label for="email" class="label">
        <span class="label-text">Email</span>
        <input type="email" id="email" name="email" class="input" required autofocus>
      </label>
  
      <label for="password" class="label">
        <span class="label-text">Password</span>
        <input type="password" id="password" name="password" class="input" required>
      </label>
  
      <button type="submit" class="button button-outline">Log in</button>
  
      @if ($errors->any())
        <ul class="errors">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      @endif
    </form>
  </div>
</body>

<style>
  .page {
    padding: 0 var(--size-base);
  }

  .page * {
    max-width: 65ch;
  }

  .page-title {
    font-size: var(--size-5xl);
    margin-block: var(--size-5xl);
  }

  .login-form {
    border-radius: var(--size-base);
    display: flex;
    flex-direction: column;
    max-width: 65ch;
    width: 100%;
  }

  .label, .button {
    margin-block-end: var(--size-base);
  }

  .button {
    border: 2px solid var(--color-neutral-600);
    color: var(--color-neutral-600);
    font-weight: 600;
  }

  .errors {
    color: var(--color-red-600);
    font-size: var(--size-xs);
    list-style: none;
  }
</style>

</html>