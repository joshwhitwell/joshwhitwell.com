<x-layouts.app>
  <form action="/login" method="post" @class([
    'flex',
    'flex-col',
    'items-stretch',
    'md:max-w-100',
    'mx-auto',
    'pt-[146px]',
    'w-full',
  ])>
    @csrf

    @foreach (['email' => 'Email', 'password' => 'Password'] as $name => $label)
      <div @class([
        'flex',
        'flex-col',
        'mb-6',
      ])>
        <label for="{{ $name }}" @class(['font-medium'])>{{ $label }}</label>
        <input
          id="{{ $name }}"
          name="{{ $name }}"
          type="{{ $name }}"
          autocomplete="{{ $name }}"
          value="{{ $name === 'email' ? old('email') : null }}"
          required
          @class([
            'border-2',
            $errors->has($name) ? 'border-red-500' : 'border-stone-700',
            'p-2',
            'rainbow',
            'mb-6' => !$errors->has($name)
          ])
        >
        @error($name)
          <p @class(['text-red-500'])>{{ $message }}</p>
        @enderror
      </div>
    @endforeach

    <button @class([
      'bg-stone-700',
      'border-2',
      'border-stone-700',
      'font-medium',
      'mt-4',
      'p-2',
      'rainbow',
      'text-stone-100',
    ])>Log in</button>
  </form>
</x-layouts.app>
