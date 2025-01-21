<x-layouts.workout-app :$headTitle :$breadcrumbs>

    <h4 class="text-2xl my-7 mx-4">{{$workout['name']}}</h4>

@if (!empty($workout['exercises']))

    <ol>

        @foreach ($workout['exercises'] as $exercise)

            <li class="my-7 mx-4">

                <h5 class="text-xl mb-1">

                    {{ $exercise['name'] }}

                    @if (!empty($exercise['url']))

                        <a href="{{ $exercise['url'] }}" target="_blank" class="text-base text-blue-500 ml-1">Watch</a>

                    @endif

                </h5>

                @if (!empty($exercise['notes']))

                    <p class="mb-1">

                        {{ $exercise['notes'] }}

                    </p>

                @endif

                @if (!empty($exercise['substitutionOne']))

                    <div class="mb-1">

                        <a href="{{ $exercise['substitutionOne']['url'] }}" target="_blank" class="text-base text-blue-500">

                            {{ $exercise['substitutionOne']['name'] }}

                        </a>

                    </div>

                @endif

                @if (!empty($exercise['substitutionTwo']))

                    <div class="mb-1">

                        <a href="{{ $exercise['substitutionTwo']['url'] }}" target="_blank" class="text-base text-blue-500">

                            {{ $exercise['substitutionTwo']['name'] }}

                        </a>

                    </div>

                @endif

                @if (!empty($exercise['maxWarmUpSets']))

                    <ol>

                        @for ($i = 1; $i <= $exercise['maxWarmUpSets']; $i++)

                            <li>

                                <h6 class="text-lg my-5">

                                    Warm-Up Set {{ $i }}

                                    @if (isset($exercise['minWarmUpSets']) && $i > $exercise['minWarmUpSets'])

                                        <span class="text-sm">(Optional)</span>

                                    @endif

                                </h6>

                            </li>

                        @endfor

                    </ol>

                @endif

                @if (!empty($exercise['maxSets']))

                    <ol>

                        @for ($i = 1; $i <= $exercise['maxSets']; $i++)

                            <li class="my-5">

                                <h6 class="text-lg">

                                    Set {{ $i }}

                                    @if (isset($exercise['minSets']) && $i > $exercise['minSets'])

                                        <span class="text-sm">(Optional)</span>

                                    @endif

                                    @if (!empty($exercise['rpeRepsRest'][$i]))

                                        <span class="text-sm">{!! $exercise['rpeRepsRest'][$i] !!}</span>

                                    @endif

                                </h6>

                                @if ($i === $exercise['maxSets'] && !empty($exercise['lastSetIntensityTechnique']))

                                    <p class="text-sm">

                                        {{ $exercise['lastSetIntensityTechnique'] }}

                                    </p>

                                @endif

                                <div class="grid grid-cols-2 gap-1">
                                    <label for="reps">Reps</label>
                                    <label for="weight">Weight</label>
                                    <input type="number" name="reps" id="reps" class="border">
                                    <input type="number" name="weight" id="weight" class="border">
                                </div>

                            </li>

                        @endfor

                    </ol>

                @endif

            </li>

        @endforeach

    </ol>

@endif

</x-layouts.workout-app>

