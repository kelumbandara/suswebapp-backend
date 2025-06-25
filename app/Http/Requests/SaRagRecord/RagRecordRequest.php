<?php
namespace App\Http\Requests\SaRagRecord;

use Illuminate\Foundation\Http\FormRequest;

class RagRecordRequest extends FormRequest
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
            'employeeType'      => 'required|string',
            'employeeId'        => 'required|string',
            'employeeName'      => 'required|string',
            'division'          => 'required|string',
            'dateOfJoin'        => 'required|string',
            'designation'       => 'required|string',
            'department'        => 'required|string',
            'gender'            => 'required|string',
            'age'               => 'required|numeric',
            'dateOfBirth'       => 'required|string',
            'servicePeriod'     => 'required|string',
            'tenureSplit'       => 'required|string',
            'sourceOfHiring'    => 'required|string',
            'function'          => 'nullable|string',
            'reportingManager'  => 'required|string',
            'country'           => 'required|string',
            'state'             => 'required|string',
            'origin'            => 'required|string',
            'category'          => 'required|string',
            'discussionSummary' => 'required|string',
            'remark'            => 'required|string',
            'employmentType'    => 'required|string',
            'status'            => 'nullable|string',
            'rag'               => 'nullable|string',
        ];
    }
}
