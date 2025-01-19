<x-layouts.workout-app :$headTitle :$breadcrumbs>

@if (!empty($workout['exercises']))

    <ol>

        @foreach ($workout['exercises'] as $exercise)

            <li>

                <h5>

                    {{ $exercise['name'] }}

                    @if (!empty($exercise['url']))

                        <a href="{{ $exercise['url'] }}" target="_blank">Watch</a>

                    @endif

                </h5>

                @if (!empty($exercise['notes']))

                    <p>

                        {{ $exercise['notes'] }}

                    </p>

                @endif

                @if (!empty($exercise['substitutionOne']))

                    <div>

                        <a href="{{ $exercise['substitutionOne']['url'] }}" target="_blank">

                            {{ $exercise['substitutionOne']['name'] }}

                        </a>

                    </div>

                @endif

                @if (!empty($exercise['substitutionTwo']))

                    <div>

                        <a href="{{ $exercise['substitutionTwo']['url'] }}" target="_blank">

                            {{ $exercise['substitutionTwo']['name'] }}

                        </a>

                    </div>

                @endif

                @if (!empty($exercise['maxWarmUpSets']))

                    <ol>

                        @for ($i = 1; $i <= $exercise['maxWarmUpSets']; $i++)

                            <li>

                                <h6>

                                    Warm-Up Set {{ $i }}

                                    @if (isset($exercise['minWarmUpSets']) && $i > $exercise['minWarmUpSets'])

                                        <span>(Optional)</span>

                                    @endif

                                </h6>

                            </li>

                        @endfor

                    </ol>

                @endif

                @if (!empty($exercise['maxSets']))

                    <ol>

                        @for ($i = 1; $i <= $exercise['maxSets']; $i++)

                            <li>

                                <h6>

                                    Set {{ $i }}

                                    @if (isset($exercise['minSets']) && $i > $exercise['minSets'])

                                        <span>(Optional)</span>

                                    @endif

                                    @if (!empty($exercise['rpeRepsRest'][$i]))

                                        <span>{!! $exercise['rpeRepsRest'][$i] !!}</span>

                                    @endif

                                </h6>

                                @if ($i === $exercise['maxSets'] && !empty($exercise['lastSetIntensityTechnique']))

                                    <p>

                                        {{ $exercise['lastSetIntensityTechnique'] }}

                                    </p>

                                @endif

                            </li>

                        @endfor

                    </ol>

                @endif

            </li>

        @endforeach

    </ol>

@endif

</x-layouts.workout-app>

