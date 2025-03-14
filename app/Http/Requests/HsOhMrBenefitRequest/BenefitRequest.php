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
            'employeeId'                                       => 'nullable|string',
            'employeeName'                                     => 'nullable|string',
            'age'                                              => 'nullable|numeric',
            'contactNumber'                                    => 'nullable|string',
            'designation'                                      => 'nullable|string',
            'department'                                       => 'nullable|string',
            'supervisorOrManager'                              => 'nullable|string',
            'dateOfJoin'                                       => 'nullable|string',
            'averageWages'                                     => 'nullable|numeric',
            'division'                                         => 'nullable|string',
            'remarks'                                          => 'nullable|string',
            'applicationId'                                    => 'nullable|string',
            'applicationDate'                                  => 'nullable|string',
            'expectedDeliveryDate'                             => 'nullable|string',
            'leaveStatus'                                      => 'nullable|string',
            'leaveStartDate'                                   => 'nullable|string',
            'leaveEndDate'                                     => 'nullable|string',
            'actualDeliveryDate'                               => 'nullable|string',
            'noticeDateAfterDelivery'                          => 'nullable|string',
            'reJoinDate'                                       => 'nullable|string',
            'supportProvider'                                  => 'nullable|string',
            'benefitsAndEntitlements'                          => 'nullable|array',
            'benefitsAndEntitlements.*.benefitType'            => 'nullable|string',
            'benefitsAndEntitlements.*.amountValue'            => 'nullable|numeric',
            'benefitsAndEntitlements.*.totalDaysPaid'          => 'nullable|numeric',
            'benefitsAndEntitlements.*.amount1stInstallment'   => 'nullable|numeric',
            'benefitsAndEntitlements.*.dateOf1stInstallment'   => 'nullable|string',
            'benefitsAndEntitlements.*.amount2ndInstallment'   => 'nullable|numeric',
            'benefitsAndEntitlements.*.dateOf2ndInstallment'   => 'nullable|string',
            'benefitsAndEntitlements.*.ifBenefitReceived'      => 'nullable|string',
            'benefitsAndEntitlements.*.beneficiaryName'        => 'nullable|string',
            'benefitsAndEntitlements.*.beneficiaryAddress'     => 'nullable|string',
            'benefitsAndEntitlements.*.beneficiaryTotalAmount' => 'nullable|numeric',
            'benefitsAndEntitlements.*.beneficiaryDate'        => 'nullable|string',
            'benefitsAndEntitlements.*.description'            => 'nullable|string',
            'medicalDocuments'                                 => 'nullable|array',
            'medicalDocuments.*.documentType'                  => 'required|string',
            'medicalDocuments.*.document'                      => 'required|array',
            'medicalDocuments.*.document'                      => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',

        ];
    }
}
