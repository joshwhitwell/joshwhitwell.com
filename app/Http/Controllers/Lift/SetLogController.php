<?php

namespace App\Http\Controllers\Lift;

use App\Models\Lift\SetLog;
use Illuminate\Http\Request;
use App\Enums\Lift\LiftStatus;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class SetLogController extends Controller
{
    public function update(Request $request, SetLog $setLog)
    {
        Gate::authorize('belongs-to-user', $setLog);

        $validated = $request->validate([
            'reps_' . $setLog->id => ['nullable', 'integer', 'min:0'],
            'weight_' . $setLog->id => ['nullable', 'numeric', 'min:0'],
            'duration_' . $setLog->id => ['nullable', 'integer', 'min:0'],
            'status_' . $setLog->id => [Rule::enum(LiftStatus::class)]
        ]);

        $setLog->update($validated);

        return redirect()->back();
    }
}
