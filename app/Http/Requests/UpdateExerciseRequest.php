<?php

namespace App\Http\Requests;

use App\Models\Exercise;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:exercises,name,' . $this->exercise->id,
            'muscle_group' => 'required|string|in:' . implode(',', Exercise::$muscleGroups)
        ];
    }
}
