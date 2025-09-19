<x-app.layout title='Translations'>
    <div class="page">
        <div class="page-title__container">
            <h1 class="page-title">Translations</h1>

            <a href="{{ route('translations.create') }}">+ Add a translation</a>
        </div>

        @if($translations->isNotEmpty())
            <ul class="index-list">
                @foreach($translations as $translation)
                    <li>
                        <a href="{{ route('translations.edit', $translation) }}">
                            <h2>
                                {{ $translation->title }}
                            </h2>
                        </a>
                    </li>
                @endforeach
            </ul>

            {{ $translations->links() }}
        @else
            <em>No translations</em>
        @endif
    </div>

    <style>
        .index-list {
            display: flex;
            flex-direction: column;
            row-gap: var(--size-base);
            
            h2 {
                font-size: var(--size-lg-1);
            }
        }
    </style>
</x-app.layout>
