<?php

namespace App\Http\Requests\SaAttritionRecord;

use Illuminate\Foundation\Http\FormRequest;

class AttritionRecordRequest extends FormRequest
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
            'employeeName'             => 'required|string',
            'employeeId'               => 'required|string',
            'country'              => 'required|string',
            'state'                    => 'required|string',
            'resignedDate'             => 'required|string',
            'relievedDate'             => 'required|string',
            'division'                 => 'required|string',
            'designation'              => 'required|string',
            'department'               => 'required|string',
            'perDaySalary'            => 'required|string',
            'dateOfJoin'               => 'required|string',
            'employmentClassification' => 'required|string',
            'employmentType'           => 'required|string',
            'isHostelAccess'           => 'required|boolean',
            'isWorkHistory'            => 'required|boolean',
            'resignationType'          => 'required|string',
            'resignationReason'        => 'required|string',
            'servicePeriod'            => 'required|string',
            'tenureSplit'              => 'required|string',
            'isNormalResignation'      => 'required|boolean',
            'remark'                   => 'nullable|string',
            'status'                   => 'nullable|string',
            'createdByUser'            => 'nullable|integer',
            'updatedBy'                => 'nullable|integer',
            'rejectedBy'               => 'nullable|integer',
            'inprogressBy'             => 'nullable|integer',
            'approvedBy'               => 'nullable|integer',
        ];
    }
}
