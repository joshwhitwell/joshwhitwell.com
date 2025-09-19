<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationFormRequest;
use App\Models\Translation;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $translations = Translation::orderByDesc('created_at')->paginate(100);
        return view('app.translations.index', compact(['translations']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.translations.form', ['translation' => New Translation]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TranslationFormRequest $request)
    {
        $translation = Translation::create($request->safe()->all());
        return redirect()->route('translations.edit', $translation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Translation $translation)
    {
        return view('app.translations.form', compact(['translation']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TranslationFormRequest $request, Translation $translation)
    {
        $translation->update($request->safe()->all());
        return redirect()->route('translations.edit', $translation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        $translation->delete();
        return redirect()->route('translations.index');
    }
}
