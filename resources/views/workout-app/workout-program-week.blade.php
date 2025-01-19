<x-layouts.workout-app :$headTitle :$breadcrumbs>

    @if (!empty($week['workouts']))

        <ol>

            @foreach ($week['workouts'] as $workout)

                <li>

                    <h4>

                        <a href="{{ $workout['route'] }}">{{ $workout['name'] }}</a>

                    </h4>

                </li>

            @endforeach

        </ol>

    @endif

</x-layouts.workout-app>
