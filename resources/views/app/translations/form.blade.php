<?php
    $isCreating = $translation->doesntExist();
    $title = $isCreating ? 'New Translation' : $translation->title;
?>

<x-app.layout title="{{ $title }}">
    <div class="page">
        <a href="{{ route('translations.index') }}">&larr; Back to translations</a>

        <div class="page-title__container">
            <h1 class="page-title">{{ $title }}</h1>
        </div>

        <x-app.form
            action="{{ $isCreating ? route('translations.store') : route('translations.update', $translation) }}"
            method="put"
        >
            <x-input
                name="slug"
                label="Slug"
                help="For example: the-flowers-of-evil"
                value="{{ old('slug', $translation->slug) }}"
            />
            <x-input
                name="title"
                label="Title"
                help="For example: The Flowers of Evil"
                value="{{ old('slug', $translation->title) }}"
            />
            <x-input
                name="text"
                label="Text"
                type="textarea"
                help="For example: To the reader..."
                value="{{ old('slug', $translation->text) }}"
            />
            <x-button>{{ $isCreating ? 'Create' : 'Update' }}</x-button>
        </x-app.form>
    </div>
</x-app.layout>
