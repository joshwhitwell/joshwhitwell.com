@props(['id'])

<svg {{ $attributes }}>
  <use href="/images/svg/icons.svg#{{ $id }}"></use>
</svg>
