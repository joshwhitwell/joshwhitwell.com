<?php

namespace App\Http\Controllers\My;

use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourceController extends Controller
{
    public array $validationRules = [
        'source_title' => 'sometimes|nullable|string|max:255',
        'section_title' => 'sometimes|nullable|string|max:255',
        'publication_year' => 'sometimes|nullable|integer',
        'publisher' => 'sometimes|nullable|string|max:255',
        'publisher_place' => 'sometimes|nullable|string|max:255',
        'contributors' => 'sometimes|nullable|array',
    ];

    public function index()
    {
        return view('my.sources.index', [
            'sources' => Source::orderBy('updated_at', 'desc')->paginate(50),
        ]);
    }

    public function create()
    {
        return view('my.sources.form', [
            'pageTitle' => 'New | Source',
            'formAction' => route('my.sources.store'),
            'formMethod' => 'POST',
            'submitButtonText' => 'Create',
            'source' => new Source,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->getValidated($request);

        Source::create($validated);

        return redirect()->route('my.sources.index');
    }

    public function edit(Source $source)
    {
        return view('my.sources.form', [
            'pageTitle' => 'Edit | Source',
            'formAction' => route('my.sources.update', $source),
            'formMethod' => 'PUT',
            'submitButtonText' => 'Update',
            'source' => $source,
        ]);
    }

    public function update(Request $request, Source $source)
    {
        $validated = $this->getValidated($request);

        $source->update($validated);

        return redirect()->route('my.sources.edit', $source);
    }

    public function destroy(Source $source)
    {
        $source->delete();

        return redirect()->route('my.sources.index');
    }

    public function getValidated(Request $request): array
    {
        $validated = $request->validate($this->validationRules);

        if (is_array($validated['contributors'])) {
            $validated['contributors'] = array_values(
                array_filter(
                    $validated['contributors'],
                    fn($contributor) => !empty($contributor['first_name']) || !empty($contributor['last_name'])
                )
            );
        }

        return $validated;
    }
}
