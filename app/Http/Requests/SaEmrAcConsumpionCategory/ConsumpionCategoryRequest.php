<?php

namespace App\Http\Requests\SaEmrAcConsumpionCategory;

use Illuminate\Foundation\Http\FormRequest;

class ConsumpionCategoryRequest extends FormRequest
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
            'categoryName' => 'required|string',
            'unitName' => 'required|string',
            'sourceName' => 'required|string',
        ];
    }
}
