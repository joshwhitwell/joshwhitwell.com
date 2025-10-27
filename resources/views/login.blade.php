<x-layouts.app title="Log in">
  <x-forms.form
    action="/login"
    class="fixed inset-0 m-auto h-fit w-full max-w-sm rounded-lg bg-white p-8"
  >
    <div class="mb-5">
      <i
        class="size-10 text-neutral-500"
        data-lucide="log-in"
      ></i>
      <h1 class="my-3 text-5xl">Log in</h1>
      <a
        class="text-neutral-400"
        href="{{ config("app.url") }}"
      >{{ config("app.url") }}</a>
    </div>
    <x-forms.input
      label="Email"
      name="email"
      type="email"
    />
    <x-forms.input
      label="Password"
      name="password"
      type="password"
    />
    <x-forms.button>
      <i
        class="size-5"
        data-lucide="log-in"
      ></i>
      Log in
    </x-forms.button>
  </x-forms.form>
</x-layouts.app>
