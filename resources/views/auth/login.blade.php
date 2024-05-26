<x-app-layout title="Login">
  <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div>
      <label for="email">Email</label>
      <input
        id="email"
        type="email"
        name="email"
        :value="old('email')"
        required
        autofocus
        autocomplete="username"
      />
      @if ($errors->get('email'))
      <ul>
        @foreach ((array) $errors->get('email') as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
      @endif
    </div>

    <!-- Password -->
    <div>
      <label for="password">Password</label>

      <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="current-password"
      />

      @if ($errors->get('password'))
      <ul>
        @foreach ((array) $errors->get('password') as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
      @endif
    </div>

    <!-- Remember Me -->
    <div>
      <label for="remember_me">
        <input id="remember_me" type="checkbox" name="remember" />
        <span>Remember Me</span>
      </label>
    </div>

    <div>
      <button type="submit">Log in</button>
    </div>
  </form>
</x-app-layout>
