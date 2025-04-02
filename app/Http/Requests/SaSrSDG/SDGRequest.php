<?php
namespace App\Http\Requests\SaSrSDG;

use Illuminate\Foundation\Http\FormRequest;

class SDGRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sdg' => 'required|string',
        ];
    }
}
