<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'weight' => 'required|numeric|min:0',
            'reps' => 'required|integer|min:1',
        ];
    }
}
