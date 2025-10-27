  <dialog
    class="fixed inset-0 h-screen w-full px-3 py-4"
    id="menu-popover"
    popover
  >
    <div class="grid h-full grid-rows-[min-content_1fr]">
      <header class="grid grid-cols-[40px_1fr_40px] items-center rounded-lg bg-white">
        <div></div>
        <span class="justify-self-center text-lg font-bold">Menu</span>
        <button
          class="flex h-[36px] w-[36px] items-center justify-center"
          popovertarget="menu-popover"
          type="button"
        >
          <span class="sr-only">Close menu</span>
          <i
            class="size-5"
            data-lucide="x"
          ></i>
        </button>
      </header>
      <ul class="flex flex-col gap-y-2">
        @foreach (['me' => 'Me', 'welcome' => 'Welcome'] as $route => $label)
          <li class="py-2">
            <a
              class="block w-full border-b-4 border-double"
              href="{{ route($route) }}"
            >{{ $label }}</a>
          </li>
        @endforeach
      </ul>
      <a
        class="focus:outline-offset-3 flex min-h-[40px] w-full items-center justify-center gap-x-2 self-end rounded-sm bg-neutral-700 pl-2 pr-3 text-white focus:outline-neutral-600"
        href="{{ route('logout') }}"
      >
        Log out
        <i
          class="size-5"
          data-lucide="log-out"
        ></i>
      </a>
    </div>
  </dialog>
