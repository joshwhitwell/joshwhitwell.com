<x-layout>
    <x-form action="{{ route('login') }}">
        <div>
            <label for="email" class="label">
                Email
                <input id="email" name="email" type="email" required autofocus>
            </label>
        </div>

        <div>
            <label for="password">
                Password
                <input id="password" name="password" type="password" required>
            </label>
        </div>

        <button type="submit" class="button">Log in</button>
    </x-form>
</x-layout>
