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
            'caseId'                => 'required|string',
            'type'                  => 'required|string',
            'personType'            => 'required|string',
            'name'                  => 'required|string',
            'gender'                => 'required|string',
            'employeeShift'         => 'required|string',
            'submissionDate'        => 'nullable|string',
            'businessUnit'          => 'required|string',
            'isAnonymous'           => 'boolean|nullable',
            'channel'               => 'required|string',
            'category'              => 'required|string',
            'topic'                 => 'nullable|string',
            'submission'            => 'required|string',
            'description'           => 'nullable|string',
            'remarks'               => 'nullable|string',
            'responsibleDepartment' => 'required|string',
            'humanRightsViolation'  => 'nullable|string',
            'assigneeId'            => 'nullable|string',
            'removeEvidence'        => 'nullable|array',
            'evidence'              => 'nullable|array',
            'evidence.*'            => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'status'                => 'nullable|string',
            'createdByUserId'       => 'nullable|integer',
            'updatedByUserId'       => 'nullable|integer',
            'inprogressBy'          => 'nullable|integer',

        ];
    }
}
