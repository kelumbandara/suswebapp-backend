<?php
namespace App\Http\Requests\SaGrievanceRecord;

use Illuminate\Foundation\Http\FormRequest;

class GrStoreQuSuAppRequest extends FormRequest
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
            'type'                  => 'required|string',
            'personType'            => 'required|string',
            'name'                  => 'required|string',
            'gender'                => 'required|string',
            'employeeShift'         => 'nullable|string',
            'employeeId'            => 'nullable|string',
            'submissionDate'        => 'nullable|string',
            'businessUnit'          => 'required|string',
            'isAnonymous'           => 'boolean|nullable',
            'channel'               => 'required|string',
            'category'              => 'required|string',
            'topic'                 => 'nullable|string',
            'submissions'           => 'required|string',
            'description'           => 'nullable|string',
            'dateOfJoin'            => 'nullable|string',
            'servicePeriod'         => 'nullable|string',
            'division'              => 'nullable|string',
            'remarks'               => 'nullable|string',
            'helpDeskPerson'        => 'nullable|string',
            'responsibleDepartment' => 'required|string',
            'tenureSplit'           => 'nullable|string',
            'humanRightsViolation'  => 'nullable|string',
            'assigneeId'            => 'nullable|integer',
            'removeEvidence'        => 'nullable|array',
            'evidence'              => 'nullable|array',
            'evidence.*'            => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'status'                => 'nullable|string',

        ];
    }
}
