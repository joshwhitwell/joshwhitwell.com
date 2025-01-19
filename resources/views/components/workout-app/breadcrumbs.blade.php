@props(['breadcrumbs'])

@if (!empty($breadcrumbs))

    <nav>

        <ol>

            @foreach ($breadcrumbs as $breadcrumb)

                <li>

                    <a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a>

                </li>

            @endforeach

        </ol>

    </nav>

@endif
