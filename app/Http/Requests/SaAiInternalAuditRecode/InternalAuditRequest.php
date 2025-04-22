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
            'auditId'                                    => 'required|string',
            'auditType'                                  => 'required|string',
            'department'                                 => 'required|string',
            'isAuditScheduledForSupplier'                => 'nullable|boolean',
            'supplierType'                               => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'factoryLicenseNo'                           => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'higgId'                                     => 'nullable|string',
            'zdhcId'                                     => 'nullable|string',
            'processType'                                => 'nullable|string',
            'factoryName'                                => 'required|string',
            'factoryAddress'                             => 'required|string',
            'factoryContactPersonId'                     => 'required|string',
            'factoryContactNumber'                       => 'required|string',
            'factoryEmail'                               => 'required|string',
            'designation'                                => 'required|string',
            'description'                                => 'nullable|string',
            'auditeeId'                                  => 'nullable|string',
            'approverId'                                 => 'nullable|string',
            'auditDate'                                  => 'nullable|string',
            'dateForApproval'                            => 'nullable|string',
            'actionPlans'                                => 'nullable|array',
            'actionPlans.*.correctiveOrPreventiveAction' => 'nullable|string',
            'actionPlans.*.priority'                     => 'nullable|string',
            'actionPlans.*.approverId'                   => 'nullable|string',
            'actionPlans.*.dueDate'                      => 'nullable|string',
            'actionPlans.*.date'                         => 'nullable|string',
            'answers'                                    => 'nullable|array',
            'answers.*.score'                            => 'required|string',
            'answers.*.rating'                           => 'required|string',
            'answers.*.status'                           => 'nullable|string',

        ];
    }
}
