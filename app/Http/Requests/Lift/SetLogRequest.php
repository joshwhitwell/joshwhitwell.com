<?php

namespace App\Http\Requests\Lift;

use Illuminate\Foundation\Http\FormRequest;

class SetLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reps' => ['nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
