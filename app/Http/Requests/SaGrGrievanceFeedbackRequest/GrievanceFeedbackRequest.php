<?php
namespace App\Http\Requests\SaGrGrievanceFeedbackRequest;

use Illuminate\Foundation\Http\FormRequest;

class GrievanceFeedbackRequest extends FormRequest
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
            'feedback' => 'required|string',
            'stars'    => 'required|integer|min:1|max:5',
        ];
    }
}
