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
            'division'                      => 'required|string',
            'location'                      => 'required|string',
            'department'                    => 'required|string',
            'supervisorName'                => 'required|string',
            'imageUrl'                      => 'nullable|string',
            'category'                      => 'required|string',
            'subCategory'                   => 'required|string',
            'accidentType'                  => 'required|string',
            'description'                   => 'required|string',
            'accidentDate'                  => 'required|string',
            'reportedDate'                  => 'nullable|string',
            'affectedPrimaryRegion'         => 'required|string',
            'assignee'                      => 'required|string',
            'witnesses'                     => 'nullable|array',
            'witnesses.*.employeeId'        => 'nullable|string',
            'witnesses.*.name'      => 'nullable|string',
            'witnesses.*.division'          => 'nullable|string',
            'witnesses.*.department'        => 'nullable|string',
            'effectedIndividuals'           => 'required|array',
            'effectedIndividuals.*.personType' => 'nullable|string',
            'effectedIndividuals.*.employeeId'  => 'nullable|integer',
            'effectedIndividuals.*.name'  => 'nullable|string',
            'effectedIndividuals.*.gender'      => 'nullable|string|in:Male,Female,other',
            'effectedIndividuals.*.age'         => 'nullable|integer|min:0',
            'effectedIndividuals.*.dateOfJoin'  => 'nullable|string',
            'effectedIndividuals.*.employmentDuration'    => 'nullable|integer',
            'effectedIndividuals.*.industryExperience'  => 'nullable|string|in:Skill,Unskilled,Semiskilled,draft',
            'effectedIndividuals.*.designation' => 'nullable|string|max:255',
            'affectedSecondaryRegion'       => 'required|string',
            'affectedTertiaryRegion'        => 'required|string',
            'injuryCause'                   => 'required|string',
            'consultedHospital'             => 'required|string',
            'consultedDoctor'               => 'required|string',
            'workPerformed'                 => 'required|string',
            'actionTaken'                   => 'required|string',
            'accidentTime'                  => 'required|string',
            'injuryType'                    => 'required|string',
            'severity'                      => 'required|string',
            'effectedIndividuals.*.name'  => 'nullable|string',


        ];
    }

}
