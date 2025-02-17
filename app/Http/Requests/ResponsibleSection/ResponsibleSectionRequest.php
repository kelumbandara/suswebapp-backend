<?php
namespace App\Http\Requests\ResponsibleSection;

use Illuminate\Foundation\Http\FormRequest;

class ResponsibleSectionRequest extends FormRequest
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
            'sectionName'   => 'required|string|max:255',
            'sectionCode'   => 'required/json',
            'responsibleId' => 'string',
        ];
    }
}
