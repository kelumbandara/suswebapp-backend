<?php

namespace App\Http\Requests\HsOhClinicalSuite;

use Illuminate\Foundation\Http\FormRequest;

class ClinicalSuiteRequest extends FormRequest
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
            'employeeId' => 'required|string',
            'employeeName' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|numeric',
            'designation' => 'required|string',
            'division' => 'required|string',
            'department' => 'required|string',
            'subDepartment' => 'nullable|string',
            'workStatus' => 'nullable|string|in:OffDuty,OnDuty,draft',
            'symptoms' => 'nullable|string',
            'checkInDate' => 'required|string',
            'checkInTime' => 'nullable|string',
            'bodyTemperature' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'useFeetAndInches' => 'nullable|boolean',
            'feet' => 'nullable|numeric|required_if:useFeetAndInches,true',
            'inches' => 'nullable|numeric|required_if:useFeetAndInches,true',
            'bloodPressure' => 'nullable|string',
            'randomBloodSugar' => 'nullable|string',
            'consultingDoctor' => 'required|string',
            'clinicDivision' => 'required|string',
        ];
    }
}
