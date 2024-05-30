<x-app-layout title="Login">
  <x-form :action="route('login')">
    <x-input
      id="email"
      name="email"
      type="email"
      label="Email"
      autocomplete="username"
      :value="old('email')"
      :required="true"
      :autofocus="true"
    />

    <x-input
      id="password"
      name="password"
      label="Password"
      type="password"
      autocomplete="current-password"
      :required="true"
    />

    <x-input
      id="remember_me"
      name="remember"
      type="checkbox"
      label="Remember"
      value="1"
      :checked="old('remember') ? true : false"
    />
  </x-form>
</x-app-layout>
