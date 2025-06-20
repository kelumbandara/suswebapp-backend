<?php
namespace App\Http\Requests\SaGrievanceRecord;

use Illuminate\Foundation\Http\FormRequest;

class GrStoreComGriRequest extends FormRequest
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
            'supervisor'            => 'required|string',
            'employeeShift'         => 'required|string',
            'employeeId'            => 'required|string',
            'location'              => 'nullable|string',
            'submissionDate'        => 'nullable|string',
            'businessUnit'          => 'required|string',
            'dueDate'               => 'nullable|string',
            'assigneeId'            => 'nullable|string',
            'isAnonymous'           => 'boolean|nullable',
            'channel'               => 'required|string',
            'category'              => 'required|string',
            'topic'                 => 'required|string',
            'submission'            => 'required|string',
            'description'           => 'nullable|string',
            'remarks'               => 'nullable|string',
            'helpDeskPerson'        => 'nullable|string',
            'responsibleDepartment' => 'required|string',
            'humanRightsViolation'  => 'required|string',
            'frequencyRate'         => 'required|string',
            'severityScore'         => 'nullable|string',
            'scale'                 => 'required|string',
            'removeEvidence'        => 'nullable|array',
            'evidence'              => 'nullable|array',
            'evidence.*'            => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'status'                => 'nullable|string',
            'createdByUserId'       => 'nullable|integer',
            'updatedByUserId'       => 'nullable|integer',
            'inprogressBy'          => 'nullable|integer',
            'openedByUserId'        => 'nullable|integer',

        ];
    }
}
