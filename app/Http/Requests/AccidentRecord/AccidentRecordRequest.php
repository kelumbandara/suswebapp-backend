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
            'division'                                 => 'nullable|string',
            'location'                                 => 'nullable|string',
            'department'                               => 'nullable|string',
            'supervisorName'                           => 'nullable|string',
            'imageUrl'                                 => 'nullable|array',
            'imageUrl.*'                               => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'category'                                 => 'nullable|string',
            'subCategory'                              => 'nullable|string',
            'accidentType'                             => 'nullable|string',
            'description'                              => 'nullable|string',
            'accidentDate'                             => 'nullable|string',
            'reportedDate'                             => 'nullable|string',
            'affectedPrimaryRegion'                    => 'nullable|string',
            'affectedSecondaryRegion'                  => 'nullable|string',
            'affectedTertiaryRegion'                   => 'nullable|string',
            'assigneeId'                               => 'nullable|string',
            'injuryCause'                              => 'nullable|string',
            'rootCause'                                => 'nullable|string',
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
        return [];
    }

}
