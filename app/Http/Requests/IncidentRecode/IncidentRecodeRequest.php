<?php
namespace App\Http\Requests\IncidentRecode;

use Illuminate\Foundation\Http\FormRequest;

class IncidentRecodeRequest extends FormRequest
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
            'division'                                 => 'required|string',
            'location'                                 => 'required|string',
            'circumstances'                            => 'nullable|string',
            'removeDoc'                                => 'nullable|array',
            'evidence'                                 => 'nullable|array',
            'evidence.*'                               => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'typeOfNearMiss'                           => 'nullable|string',
            'typeOfConcern'                            => 'nullable|string',
            'factors'                                  => 'nullable|string',
            'causes'                                   => 'nullable|string',
            'assigneeId'                               => 'required|string',
            'incidentDetails'                          => 'nullable|string',
            'incidentTime'                             => 'nullable|string',
            'incidentDate'                             => 'required|string',
            'severity'                                 => 'nullable|string',
            'witnesses'                                => 'nullable|array',
            'witnesses.*.employeeId'                   => 'nullable|string',
            'witnesses.*.name'                         => 'nullable|string',
            'witnesses.*.division'                     => 'nullable|string',
            'witnesses.*.department'                   => 'nullable|string',
            'effectedIndividuals'                      => 'required|array',
            'effectedIndividuals.*.personType'         => 'required|string',
            'effectedIndividuals.*.employeeId'         => 'nullable|string',
            'effectedIndividuals.*.name'               => 'required|string',
            'effectedIndividuals.*.gender'             => 'nullable|string|in:Male,Female,other',
            'effectedIndividuals.*.age'                => 'required|string',
            'effectedIndividuals.*.dateOfJoin'         => 'nullable|string',
            'effectedIndividuals.*.employmentDuration' => 'nullable|string',
            'effectedIndividuals.*.industryExperience' => 'required|string|in:Skill,Unskilled,Semiskilled,draft',
            'effectedIndividuals.*.designation'        => 'nullable|string|max:255',

        ];
    }
}
