<x-layout>
    <div class="page">
        <div class="page-title">
            <h1>Josh Whitwell</h1>
            <small>{{ now()->format('D M d g:i A') }}</small>
        </div>

        <div class="column">
            <section class="page-section">
                <form action="{{ route('notes.store') }}" method="post" class="notes-form">
                    @csrf

                    <div class="notes-form__header">
                        <label for="body">Write a note</label>

                        <select id="type" name="type">
                            <option value="">— Type —</option>
                            @foreach ($noteTypes as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>

                        <p class="help-text">Save a thought for later</p>
                    </div>

                    <textarea id="body" name="body"></textarea>

                    <div class="notes-form__controls">
                        <button>Save</button>
                    </div>
                </form>
            </section>

            <section class="page-section">
                <div class="notes-list__header">
                    <h2>Notes</h2>
                    <form action="{{ route('me') }}">
                        <select id="filter[notes]" name="filter[notes]" onchange="this.form.submit()">
                            <option value="">— Filter —</option>
                            @foreach ($noteTypes as $type)
                                <option
                                    value="{{ $type['value'] }}"
                                    @if(isset($typeFilter) && $typeFilter === $type['value']) selected @endif
                                >
                                    {{ $type['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <ol class="notes-list">
                    @forelse ($notes as $note)
                        <li>
                            <small>{{ $note->created_at->format('D M d g:i A') }}</small><br>
                            {!! $note->body !!}
                        </li>
                    @empty
                        <em>No notes</em>
                    @endforelse
                </ol>

                {{ $notes->links() }}
            </section>
        </div>
    </div>
</x-layout>
