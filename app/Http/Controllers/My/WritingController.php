<?php

namespace App\Http\Controllers\My;

use App\Models\Writing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WritingController extends Controller
{
    public array $validationRules = [
        'type' => 'sometimes|nullable|string|max:255',
        'title' => 'sometimes|nullable|string|max:255',
        'body' => 'required|string|min:1',
        'visibility' => 'sometimes|boolean',
        'written_at' => 'sometimes|nullable|date',
    ];

    public function index()
    {
        return view('my.writings.index', [
            'writings' => Writing::orderBy('updated_at', 'desc')->paginate(50),
        ]);
    }

    public function create()
    {
        return view('my.writings.form', [
            'pageTitle' => 'New | Writing',
            'formAction' => route('my.writings.store'),
            'formMethod' => 'POST',
            'submitButtonText' => 'Create',
            'writing' => new Writing(['visibility' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'visibility' => (bool) $request->input('visibility')
        ]);

        $validated = $request->validate($this->validationRules);

        Writing::create($validated);

        return redirect()->route('my.writings.index');
    }

    public function edit(Writing $writing)
    {
        return view('my.writings.form', [
            'pageTitle' => 'Edit | Writing',
            'formAction' => route('my.writings.update', $writing),
            'formMethod' => 'PUT',
            'submitButtonText' => 'Update',
            'writing' => $writing,
        ]);
    }

    public function update(Request $request, Writing $writing)
    {
        $request->merge([
            'visibility' => (bool) $request->input('visibility')
        ]);

        $validated = $request->validate($this->validationRules);

        $writing->update($validated);

        return redirect()->route('my.writings.edit', $writing);
    }

    public function destroy(Writing $writing)
    {
        $writing->delete();

        return redirect()->route('my.writings.index');
    }
}
