@props(['exercise'])

@if (!empty($exercise['substitution_option_1']))

    <div class="text-sm leading-none">

        @if (!empty($exercise['substitution_option_1_link']))

            <a
                href="{{ $exercise['substitution_option_1_link'] }}"
                target="_blank"
                class="text-blue-600 underline"
            >
                {{ $exercise['substitution_option_1'] }}
            </a>

        @else

            <span>{{ $exercise['substitution_option_1'] }}</span>

        @endif

    </div>

@endif

@if (!empty($exercise['substitution_option_2']))

    <div class="text-sm leadning-none">

        @if (!empty($exercise['substitution_option_2_link']))

            <a
                href="{{ $exercise['substitution_option_2_link'] }}"
                target="_blank"
                class="text-blue-600 underline"
            >

                {{ $exercise['substitution_option_2'] }}

            </a>

        @else

            <span>{{ $exercise['substitution_option_2'] }}</span>

        @endif

    </div>

@endif
