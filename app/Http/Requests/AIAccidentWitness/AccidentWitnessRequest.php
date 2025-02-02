<?php

namespace App\Http\Requests\AIAccidentWitness;

use Illuminate\Foundation\Http\FormRequest;

class AccidentWitnessRequest extends FormRequest
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
            'accidentId' => 'nullable|integer|exists:hs_ai_accident_records,id',
            'employeeId' => 'required|string',
            'employeeName' => 'required|string',
            'division' => 'required|string',
            'department' => 'nullable|string',
        ];

    }
}
