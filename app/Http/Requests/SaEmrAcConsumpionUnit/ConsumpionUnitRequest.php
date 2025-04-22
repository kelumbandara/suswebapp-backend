<?php

namespace App\Http\Requests\SaEmrAcConsumpionUnit;

use Illuminate\Foundation\Http\FormRequest;

class ConsumpionUnitRequest extends FormRequest
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
        return [
            'unitName' => 'required|string',
        ];
    }
}
