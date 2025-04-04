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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division'                    => 'required|string',
            'auditTitle'                  => 'required|string',
            'auditType'                   => 'required|string',
            'department'                  => 'required|string',
            'isAuditScheduledForSupplier' => 'required|boolean',
            'supplierType'                => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'factoryLicenseNo'            => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'higgId'                      => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'zdhcId'                      => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'processType'                 => 'nullable|string|required_if:isAuditScheduledForSupplier,true',
            'status'                      => 'required|string',
            'factoryName'                 => 'required|string',
            'factoryAddress'              => 'required|string',
            'factoryContactPerson'        => 'required|string',
            'factoryContactNumber'        => 'required|string',
            'factoryEmail'                => 'required|string',
            'designation'                 => 'required|string',
            'description'                 => 'required|string',
            'auditeeId'                   => 'required|string',
            'approverId'                  => 'required|string',
            'auditDate'                   => 'required|string',
            'dateForApproval'             => 'required|string',
        ];
    }
}
