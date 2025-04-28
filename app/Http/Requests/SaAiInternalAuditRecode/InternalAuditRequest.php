<?php
namespace App\Http\Requests\SaAiInternalAuditRecode;

use Illuminate\Foundation\Http\FormRequest;

class InternalAuditRequest extends FormRequest
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
            'division'                                   => 'required|string',
            'auditId'                                    => 'required|numeric',
            'auditType'                                  => 'required|string',
            'department'                                 => 'required|array',
            'isAuditScheduledForSupplier'                => 'nullable|boolean',
            'supplierType'                               => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'factoryLicenseNo'                           => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'higgId'                                     => 'nullable|string',
            'zdhcId'                                     => 'nullable|string',
            'processType'                                => 'nullable|string',
            'factoryName'                                => 'required|string',
            'factoryAddress'                             => 'required|string',
            'factoryContactPersonId'                     => 'required|numeric',
            'factoryContactNumber'                       => 'required|string',
            'factoryEmail'                               => 'required|string',
            'designation'                                => 'required|string',
            'status'                                     => 'nullable|string',
            'description'                                => 'nullable|string',
            'auditeeId'                                  => 'nullable|numeric',
            'approverId'                                 => 'nullable|numeric',
            'auditDate'                                  => 'nullable|string',
            'dateForApproval'                            => 'nullable|string',
            'actionPlans'                                => 'nullable|array',
            'actionPlans.*.correctiveOrPreventiveAction' => 'nullable|string',
            'actionPlans.*.priority'                     => 'nullable|string',
            'actionPlans.*.approverId'                   => 'nullable|numeric',
            'actionPlans.*.dueDate'                      => 'nullable|string',
            'actionPlans.*.date'                         => 'nullable|string',
            'answers'                                    => 'nullable|array',
            'answers.*.questionRecoId'                   => 'required|numeric',
            'answers.*.queGroupId'                       => 'required|numeric',
            'answers.*.questionId'                       => 'required|numeric',
            'answers.*.score'                            => 'required|numeric',
            'answers.*.rating'                           => 'required|string',
            'answers.*.status'                           => 'nullable|string',

        ];
    }
}
