<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TranslationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $translationId = $this->route('translation')->id ?? null;
        return [
            'slug' => 'required|string|unique:translations,slug' . ($translationId ? ',' . $translationId : ''),
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ];
    }
}
