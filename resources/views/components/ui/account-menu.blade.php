<?php
  $fixedClass = [
    'fixed',
    'right-4',
    'top-4',
    'z-999',
  ];
  $buttonClass = [
    'border-2',
    'border-stone-700',
    'flex',
    'h-10',
    'items-center',
    'justify-center',
    'rainbow',
    'w-10',
  ];
  $iconClass = [
    'h-5',
    'w-5',
  ];
  $liClass = [
    'bg-stone-100',
    'active:z-999',
    'focus:z-999',
    'focus-within:z-999',
    'hover:z-999',
    'z-1',
  ];
  $linkClass = [
    'border-2',
    'border-stone-700',
    'flex',
    'font-medium',
    'h-10',
    'items-center',
    'mt-[-2px]',
    'px-2',
    'rainbow',
  ];
?>

<div @class($fixedClass)>
  <div class="bg-stone-100">
    <button popovertarget="account-menu" @class($buttonClass)>
      <span class="sr-only">Open menu</span>
      <x-ui.icon id="fa-sharp-solid-bars" @class($iconClass)/>
    </button>
  </div>
</div>

<div
  popover
  id="account-menu"
  @class(array_merge($fixedClass, [
    'bg-transparent',
    'ml-auto',
  ]))
>
  <ul class="flex flex-col">
    <li @class(array_merge($liClass, [
      'ml-auto',
      'w-fit',
    ]))>
      <button popovertarget="account-menu" @class(array_merge($buttonClass, ['ml-auto']))>
        <span class="sr-only">Close menu</span>
        <x-ui.icon id="fa-sharp-solid-close" @class($iconClass) />
      </button>
    </li>
    @foreach ($links as $name => $label)
      <li @class($liClass)>
        <a href="{{ route($name) }}" @class($linkClass)>
          {{ $label }}
        </a>
      </li>
    @endforeach
  </ul>
</div>

