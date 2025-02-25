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
            'department'                               => 'nullable|string',
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
            'assigneeId'                               => 'required|string',
            'injuryCause'                              => 'nullable|string',
            'rootCause'                                => 'required|string',
            'consultedHospital'                        => 'nullable|string',
            'consultedDoctor'                          => 'nullable|string',
            'workPerformed'                            => 'nullable|string',
            'actionTaken'                              => 'nullable|string',
            'accidentTime'                             => 'nullable|string',
            'injuryType'                               => 'nullable|string',
            'severity'                                 => 'nullable|string',
            'witnesses'                                => 'nullable|array',
            'witnesses.*.employeeId'                   => 'nullable|string',
            'witnesses.*.name'                         => 'nullable|string',
            'witnesses.*.division'                     => 'nullable|string',
            'witnesses.*.department'                   => 'nullable|string',
            'effectedIndividuals'                      => 'nullable|array',
            'effectedIndividuals.*.personType'         => 'required|string',
            'effectedIndividuals.*.employeeId'         => 'nullable|string',
            'effectedIndividuals.*.name'               => 'required|string',
            'effectedIndividuals.*.gender'             => 'nullable|string|in:Male,Female,other',
            'effectedIndividuals.*.age'                => 'required|integer|min:0',
            'effectedIndividuals.*.dateOfJoin'         => 'nullable|string',
            'effectedIndividuals.*.employmentDuration' => 'nullable|integer',
            'effectedIndividuals.*.industryExperience' => 'nullable|string|in:Skill,Unskilled,Semiskilled,draft',
            'effectedIndividuals.*.designation'        => 'nullable|string|max:255',

        ];
    }
    public function messages()
    {
        return [
            'division.nullable'                                 => 'Division is nullable.',
            'location.nullable'                                 => 'Location is nullable.',
            'department.nullable'                               => 'Department is nullable.',
            'supervisorName.nullable'                           => 'Supervisor name is nullable.',
            'category.nullable'                                 => 'Category is nullable.',
            'subCategory.nullable'                              => 'Sub Category is nullable.',
            'accidentType.nullable'                             => 'Accident type is nullable.',
            'accidentDate.nullable'                             => 'Accident date is nullable.',
            'assignee.nullable'                                 => 'Assignee is nullable.',
            'effectedIndividuals.*.personType.nullable'         => 'Person type is nullable.',
            'effectedIndividuals.*.employeeId.nullable'         => 'Employee ID is nullable.',
            'effectedIndividuals.*.name.nullable'               => 'Name is nullable.',
            'effectedIndividuals.*.age.nullable'                => 'Age is nullable.',
            'effectedIndividuals.*.age.min'                     => 'Age must be at least 0 years.',
            'effectedIndividuals.*.industryExperience.nullable' => 'Industry experience is nullable.',
            'effectedIndividuals.*.industryExperience.in'       => 'Industry experience must be one of the following: Skill, Unskilled, Semiskilled, draft',
            'effectedIndividuals.*.designation.max'             => 'Designation must not be greater than 255 characters.',

        ];
    }

}
