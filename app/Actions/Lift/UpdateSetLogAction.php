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
            
            if (empty($setLog->completed_at)) {
                $setLog->completed_at = now();
            }

            return;
        }

        if (!isset($setLog->reps) && !isset($setLog->weight)) {
            $setLog->status = LiftStatus::NotStarted;
            $setLog->completed_at = null;

            return;
        }

        if (isset($setLog->reps) || isset($setLog->weight)) {
            $setLog->status = LiftStatus::InProgress;
            $setLog->completed_at = null;

            return;
        }
    }
}
