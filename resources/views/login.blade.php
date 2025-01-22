<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>

    <body>

        <div class="flex items-center justify-center min-h-screen">

            <form
                method="POST"
                action="{{ route('login') }}"
                class="grid justify-center text-center"
            >

                @csrf

                <label for="email" class="text-base text-gray-900">

                    {{ __('Email') }}

                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="text-base border border-gray-300 rounded-md shadow-sm min-w-40 p-2 mb-3"
                />

                <label for="password">

                    {{ __('Password') }}

                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="text-base border border-gray-300 rounded-md shadow-sm min-w-40 p-2 mb-3"
                />

                <button type="submit" class="text-base bg-gray-800 border border-gray-800 text-white rounded-md shadow-sm p-2 mt-1">

                    {{ __('Log in') }}

                </button>

                @if ($errors->get('email'))

                    <ul>

                        @foreach ((array) $errors->get('email') as $message)

                            <li class="text-red-500 text-sm">{{ $message }}</li>

                        @endforeach

                    </ul>

                @endif

                @if ($errors->get('password'))

                    <ul>

                        @foreach ((array) $errors->get('password') as $message)

                            <li>{{ $message }}</li>

                        @endforeach

                    </ul>

                @endif

            </form>

        </div>

    </body>

</html>
