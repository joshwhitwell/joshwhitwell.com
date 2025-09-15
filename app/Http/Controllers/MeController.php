<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Enums\NoteType;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function me(Request $request)
    {
        $noteTypes = NoteType::selectOptions();
        $typeFilter = $request->filter['notes'] ?? null;
        $notes = Note::query()
            ->when($typeFilter, fn ($q) => $q->where('type', $typeFilter))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('me', compact(['noteTypes', 'notes', 'typeFilter']));
    }
}
