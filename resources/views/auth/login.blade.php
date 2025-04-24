<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&icon_names=arrow_back_ios,check,close,login,play_arrow&display=block" rel="stylesheet" />

  @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
  
  <form method="POST" action="{{ route('login') }}" class="login-form">
    <h1 class="page-title">
      <span class="material-symbols-outlined"> login </span>
      Log in
    </h1>

    <div class="login-inputs">
      @csrf
        
      <label for="email" class="label">
        <span class="label-text">Email</span>
        <input type="email" id="email" name="email" class="input" required autofocus>
      </label>
    
      <label for="password" class="label">
        <span class="label-text">Password</span>
        <input type="password" id="password" name="password" class="input" required>
      </label>
    </div>

    <div class="login-footer">
      <a href="/">
        Back to Home
      </a>

      <button type="submit" class="button">Log in</button>
  
      @if ($errors->any())
        <ul class="errors">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      @endif
    </div>
    
  </form>
</body>

<style>
body {
 padding: var(--size-base);
}

.page-title {
  display: flex;
  flex-direction: column;
  font-size: var(--size-5xl);
}

.material-symbols-outlined {
  font-size: var(--size-7xl);
}

.login-form {
  display: grid;
  row-gap: var(--size-5xl);
}

.login-inputs {
  display: flex;
  flex-direction: column;
  row-gap: var(--size-base);
}

.login-footer {
  align-items: center;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.login-footer a {
  font-size: var(--size-sm);
}

.button {
  background-color: transparent;
  border: 2px solid var(--color-neutral-950);
  color: var(--color-neutral-950);
  font-weight: 600;
  place-self: end;
}

.errors {
  color: var(--color-red-600);
  font-size: var(--size-xs);
  list-style: none;
  margin-block-start: var(--size-base);
  width: 100%;
}
</style>

</html>