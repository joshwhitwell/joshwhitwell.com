<x-layouts.workout-app :$headTitle :$breadcrumbs>

    <h3 class="text-2xl my-7">

        {{ $week['name'] }}

    </h3>

    @if (!empty($week['workouts']))

        <ol>

            @foreach ($week['workouts'] as $workout)

                <li>

                    <h4 class="text-xl my-4">

                        <a href="{{ $workout['route'] }}" class="text-blue-500">{{ $workout['name'] }}</a>

                    </h4>

                </li>

            @endforeach

        </ol>

    @endif

</x-layouts.workout-app>
