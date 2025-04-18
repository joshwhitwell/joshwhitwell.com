<?php

namespace App\Http\Controllers\Lift;

use App\Models\Lift\SetLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Actions\Lift\UpdateSetLogAction;
use App\Http\Requests\Lift\SetLogRequest;

class SetLogController extends Controller
{
    public function update(
        SetLogRequest $request,
        UpdateSetLogAction $updateSetLogAction,
        SetLog $setLog,
    ) {
        Gate::authorize('belongs-to-user', $setLog);

        $updateSetLogAction($setLog, $request);

        return redirect()->back();
    }
}
