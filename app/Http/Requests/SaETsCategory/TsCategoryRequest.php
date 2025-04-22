<?php
namespace App\Http\Requests\SaETsCategory;

use Illuminate\Foundation\Http\FormRequest;

class TsCategoryRequest extends FormRequest
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
            'categoryName'        => 'required|string',
            'possibilityCategory' => 'required|string',
            'opertunity'          => 'required|string',
        ];
    }
}
