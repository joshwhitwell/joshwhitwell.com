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
            'reps' => ['nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'status' => [Rule::enum(LiftStatus::class)]
        ]);

        $setLog->update($validated);

        return redirect()->back();
    }
}
