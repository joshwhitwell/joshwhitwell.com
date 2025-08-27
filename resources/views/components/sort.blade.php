<?php
    $request = request();
    $activeSort = $request->input('sort');
    $getParams = function ($sortParam) use ($request) {
        return array_merge(
            $request->except('sort'),
            ['sort' => $sortParam]
        );
    };
?>

<div class="x-sort">
    @foreach ([$sortName, "-$sortName"] as $sortParam)
        <a
            href="{{ route($routeName, $getParams($sortParam)) }}"
            @if ($sortParam === $activeSort) data-x-sort-active @endif
        >
            <span class="sr-only">Sort {{ $sortName }} {{ $loop->first ? 'ascending' : 'descending' }}</span>

            @if ($loop->first) &uarr; @else &darr; @endif
        </a>
    @endforeach
</div>

<style>
    .x-sort {
        display: inline-block;

        a {
            border: 1px solid black;
            color: inherit;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            min-width: 20px;
        }

        a:hover {
            border-color: dodgerblue;
            color: dodgerblue;
        }

        a[data-x-sort-active] {
            border-color: dodgerblue;
            color: dodgerblue;
        }

        a[data-x-sort-active]:hover {
            border-color: black;
            color: black;
        }
    }
</style>

