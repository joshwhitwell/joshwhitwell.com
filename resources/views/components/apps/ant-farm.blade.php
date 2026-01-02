<div @class([
  'border-2',
  'border-stone-700',
  'h-full',
  'w-full',
])>
  @push('vite')
    @vite(['resources/js/ant-farm.js'])
  @endpush

  <canvas id="antFarmCanvas" @class([
    'h-full',
    'w-full',
  ])></canvas>
</div>
