<?php

namespace App\Http\Requests;

use App\Models\Exercise;
use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:exercises,name',
            'muscle_group' => 'required|string|in:' . implode(',', Exercise::$muscleGroups)
        ];
    }
}
