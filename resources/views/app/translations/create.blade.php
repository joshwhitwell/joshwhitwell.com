<x-app.layout title='New Translation'>
    <div class="page">
        <div class="page-title__container">
            <h1 class="page-title">New Translation</h1>
        </div>

        <x-app.form action="{{ route('translations.store') }}">
            <x-input
                name="slug"
                label="Slug"
                help="For example: the-flowers-of-evil"
            />
            <x-input
                name="title"
                label="Title"
                help="For example: The Flowers of Evil"
            />
            <x-input
                name="text"
                label="Text"
                type="textarea"
                help="For example: To the reader..."
            />
            <x-button>Create</x-button>
        </x-app.form>
    </div>
</x-app.layout>
