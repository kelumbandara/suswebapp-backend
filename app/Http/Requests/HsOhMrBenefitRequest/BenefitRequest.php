<?php
namespace App\Http\Requests\HsOhMrBenefitRequest;

use Illuminate\Foundation\Http\FormRequest;

class BenefitRequest extends FormRequest
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
            'employeeId'                           => 'required|string',
            'employeeName'                         => 'required|string',
            'age'                                  => 'nullable|numeric',
            'contactNumber'                        => 'nullable|numeric',
            'designation'                          => 'required|string',
            'department'                           => 'required|string',
            'supervisorOrManager'                  => 'nullable|string',
            'dateOfJoin'                           => 'required|string',
            'averageWages'                         => 'nullable|numeric',
            'division'                             => 'required|string',
            'remarks'                              => 'nullable|string',
            'applicationId'                        => 'required|string',
            'applicationDate'                      => 'required|string',
            'expectedDeliveryDate'                 => 'nullable|string',
            'leaveStatus'                          => 'required|string',
            'leaveStartDate'                       => 'required|string',
            'leaveEndDate'                         => 'required|string',
            'actualDeliveryDate'                   => 'required|string',
            'noticeDateAfterDelivery'              => 'nullable|string',
            'reJoinDate'                           => 'required|string',
            'supportProvider'                      => 'nullable|string',
            'entitlement'                          => 'nullable|array',
            'entitlement.*.benefitType'            => 'required|string',
            'entitlement.*.amountValue'            => 'required|string',
            'entitlement.*.totalDaysPaid'          => 'required|string',
            'entitlement.*.amount1stInstallment'   => 'nullable|string',
            'entitlement.*.dateOf1stInstallment'   => 'nullable|string',
            'entitlement.*.amount2ndInstallment'   => 'nullable|string',
            'entitlement.*.dateOf2ndInstallment'   => 'nullable|string',
            'entitlement.*.ifBenefitReceived'      => 'nullable|string',
            'entitlement.*.beneficiaryName'        => 'required|string',
            'entitlement.*.beneficiaryAddress'     => 'required|string',
            'entitlement.*.beneficiaryTotalAmount' => 'required|string',
            'entitlement.*.beneficiaryDate'        => 'required|string',
            'entitlement.*.description'            => 'nullable|string',
            'documents'                            => 'nullable|array',
            'documents.*.documentType'             => 'nullable|string',
            'documents.*.document'                 => 'nullable|string',

        ];
    }
}
