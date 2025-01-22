<x-layouts.workout-app :$headTitle :$breadcrumbs>

    @if (!empty($program['phases']))

        <ol>

            @foreach ($program['phases'] as $phase)

                <li>

                    <h2 class="text-4xl my-9">{{ $phase['name'] }}</h2>

                    @if (!empty ($phase['weeks']))

                        <ol>

                            @foreach ($phase['weeks'] as $week)

                                <li class="my-7">

                                    <h3 class="text-3xl">

                                        <a href="{{ $week['route'] }}">{{ $week['name'] }}</a>

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

                                </li>

                            @endforeach

                        </ol>

                    @endif

                </li>

            @endforeach

        </ol>

    @endif

</x-layouts.workout-app>
