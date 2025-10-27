<div class="z-1 sticky top-0 p-2">
  <header class="grid grid-cols-[40px_1fr_40px] items-center rounded-lg bg-white/90 px-1 py-2">
    @if (isset($back))
      <a
        class="flex h-[36px] w-[36px] items-center justify-center"
        href="{{ $back }}"
      >
        <i
          class="size-5"
          data-lucide="arrow-left"
        ></i>
      </a>
    @else
      <div></div>
    @endif
    <span class="justify-self-center text-lg font-bold">{{ $title ?? '' }}</span>
    <button
      class="flex h-[36px] w-[36px] items-center justify-center"
      popovertarget="menu-popover"
      type="button"
    >
      <span class="sr-only">Open menu</span>
      <i
        class="size-5"
        data-lucide="menu"
      ></i>
    </button>
  </header>
  <x-app.menu-dialog />
</div>
