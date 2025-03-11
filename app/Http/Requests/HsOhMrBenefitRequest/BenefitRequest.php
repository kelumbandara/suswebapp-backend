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
            'employeeId'                                       => 'required|string',
            'employeeName'                                     => 'required|string',
            'age'                                              => 'nullable|numeric',
            'contactNumber'                                    => 'nullable|string',
            'designation'                                      => 'required|string',
            'department'                                       => 'required|string',
            'supervisorOrManager'                              => 'nullable|string',
            'dateOfJoin'                                       => 'required|string',
            'averageWages'                                     => 'nullable|numeric',
            'division'                                         => 'required|string',
            'remarks'                                          => 'nullable|string',
            'applicationId'                                    => 'required|string',
            'applicationDate'                                  => 'required|string',
            'expectedDeliveryDate'                             => 'nullable|string',
            'leaveStatus'                                      => 'required|string',
            'leaveStartDate'                                   => 'required|string',
            'leaveEndDate'                                     => 'required|string',
            'actualDeliveryDate'                               => 'required|string',
            'noticeDateAfterDelivery'                          => 'nullable|string',
            'reJoinDate'                                       => 'required|string',
            'supportProvider'                                  => 'nullable|string',
            'benefitsAndEntitlements'                          => 'nullable|array',
            'benefitsAndEntitlements.*.benefitType'            => 'required|string',
            'benefitsAndEntitlements.*.amountValue'            => 'required|numeric',
            'benefitsAndEntitlements.*.totalDaysPaid'          => 'required|numeric',
            'benefitsAndEntitlements.*.amount1stInstallment'   => 'nullable|numeric',
            'benefitsAndEntitlements.*.dateOf1stInstallment'   => 'nullable|string',
            'benefitsAndEntitlements.*.amount2ndInstallment'   => 'nullable|numeric',
            'benefitsAndEntitlements.*.dateOf2ndInstallment'   => 'nullable|string',
            'benefitsAndEntitlements.*.ifBenefitReceived'      => 'nullable|string',
            'benefitsAndEntitlements.*.beneficiaryName'        => 'required|string',
            'benefitsAndEntitlements.*.beneficiaryAddress'     => 'required|string',
            'benefitsAndEntitlements.*.beneficiaryTotalAmount' => 'required|numeric',
            'benefitsAndEntitlements.*.beneficiaryDate'        => 'required|string',
            'benefitsAndEntitlements.*.description'            => 'nullable|string',
            'medicalDocuments'                                 => 'required|array',
            'medicalDocuments.*.documentType'                  => 'nullable|string',
            'medicalDocuments.*.document'                      => 'required|array',
            'medicalDocuments.*.document'                      => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',

        ];
    }
}
