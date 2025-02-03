<?php
namespace App\Http\Requests\AIAccidentPeople;

use Illuminate\Foundation\Http\FormRequest;

class AccidentPeopleRequest extends FormRequest
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
            'accidentId'  => 'nullable|integer|exists:hs_ai_accident_records,id',
            'personType'  => 'required|string|max:255',
            'employeeId'  => 'nullable|integer',
            'personName'  => 'required|string|max:255',
            'gender'      => 'nullable|string|in:male,female,other',
            'age'         => 'required|integer|min:0',
            'dateOfJoin'  => 'nullable|date',
            'duration'    => 'nullable|integer',
            'experience'  => 'required|string|in:skill,unskilled,semiskilled,draft', 
            'designation' => 'nullable|string|max:255',
        ];
    }
}
