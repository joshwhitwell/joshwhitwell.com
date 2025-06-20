<?php

namespace App\Actions\Lift;

use App\Models\Lift\SetLog;
use App\Enums\Lift\LiftStatus;
use App\Http\Requests\Lift\SetLogRequest;

class UpdateSetLogAction
{
    public function __invoke(SetLog $setLog, SetLogRequest $request): SetLog
    {
        $setLog->fill($request->validated());

        $this->setStatus($setLog);

        $setLog->save();

        return $setLog;
    }

    private function setStatus(SetLog $setLog): void
    {
        if (isset($setLog->reps) && isset($setLog->weight)) {
            $setLog->status = LiftStatus::Completed;
            return;
        }

        if (!isset($setLog->reps) && !isset($setLog->weight)) {
            $setLog->status = LiftStatus::NotStarted;
            return;
        }

        if (isset($setLog->reps) || isset($setLog->weight)) {
            $setLog->status = LiftStatus::InProgress;
            return;
        }
    }
}
