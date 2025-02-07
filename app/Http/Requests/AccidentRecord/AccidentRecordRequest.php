<?php
namespace App\Http\Requests\AccidentRecord;

use Illuminate\Foundation\Http\FormRequest;

class AccidentRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division'                                 => 'required|string',
            'location'                                 => 'required|string',
            'department'                               => 'required|string',
            'supervisorName'                           => 'required|string',
            'imageUrl'                                 => 'nullable|string',
            'category'                                 => 'required|string',
            'subCategory'                              => 'required|string',
            'accidentType'                             => 'required|string',
            'description'                              => 'nullable|string',
            'accidentDate'                             => 'required|string',
            'reportedDate'                             => 'nullable|string',
            'affectedPrimaryRegion'                    => 'nullable|string',
            'affectedSecondaryRegion'                  => 'nullable|string',
            'affectedTertiaryRegion'                   => 'nullable|string',
            'assignee'                                 => 'required|string',
            'injuryCause'                              => 'required|string',
            'consultedHospital'                        => 'required|string',
            'consultedDoctor'                          => 'required|string',
            'workPerformed'                            => 'nullable|string',
            'actionTaken'                              => 'nullable|string',
            'accidentTime'                             => 'nullable|string',
            'injuryType'                               => 'required|string',
            'severity'                                 => 'required|string',
            'witnesses'                                => 'nullable|array',
            'witnesses.*.employeeId'                   => 'nullable|string',
            'witnesses.*.name'                         => 'nullable|string',
            'witnesses.*.division'                     => 'nullable|string',
            'witnesses.*.department'                   => 'nullable|string',
            'effectedIndividuals'                      => 'nullable|array',
            'effectedIndividuals.*.personType'         => 'required|string',
            'effectedIndividuals.*.employeeId'         => 'required|integer',
            'effectedIndividuals.*.name'               => 'required|string',
            'effectedIndividuals.*.gender'             => 'nullable|string|in:Male,Female,other',
            'effectedIndividuals.*.age'                => 'required|integer|min:0',
            'effectedIndividuals.*.dateOfJoin'         => 'nullable|string',
            'effectedIndividuals.*.employmentDuration' => 'nullable|integer',
            'effectedIndividuals.*.industryExperience' => 'required|string|in:Skill,Unskilled,Semiskilled,draft',
            'effectedIndividuals.*.designation'        => 'nullable|string|max:255',

        ];
    }
    public function messages()
    {
        return [
            'division.required'                        => 'Division is required.',
            'location.required'                        => 'Location is required.',
            'department.required'                      => 'Department is required.',
            'supervisorName.required'                  => 'Supervisor name is required.',
            'category.required'                        => 'Category is required.',
            'subCategory.required'                     => 'Sub Category is required.',
            'accidentType.required'                    => 'Accident type is required.',
            'accidentDate.required'                    => 'Accident date is required.',
            'assignee.required'                        => 'Assignee is required.',
            'effectedIndividuals.*.personType.required' => 'Person type is required.',
            'effectedIndividuals.*.employeeId.required' => 'Employee ID is required.',
            'effectedIndividuals.*.name.required'       => 'Name is required.',
            'effectedIndividuals.*.age.required'        => 'Age is required.',
            'effectedIndividuals.*.age.min'             => 'Age must be at least 0 years.',
            'effectedIndividuals.*.industryExperience.required' => 'Industry experience is required.',
            'effectedIndividuals.*.industryExperience.in' => 'Industry experience must be one of the following: Skill, Unskilled, Semiskilled, draft',
            'effectedIndividuals.*.designation.max'    => 'Designation must not be greater than 255 characters.',

        ];
        }

}
