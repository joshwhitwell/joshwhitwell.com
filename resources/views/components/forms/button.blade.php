<div>
  <button
    class="focus:outline-offset-3 ml-auto flex min-h-[40px] items-center gap-x-2 rounded-sm bg-neutral-700 pl-2 pr-3 text-white focus:outline-neutral-600"
    type="{{ $type ?? 'submit' }}"
  >
    @if ($slot->hasActualContent())
      {{ $slot }}
    @else
      Submit
    @endif
  </button>
</div>
