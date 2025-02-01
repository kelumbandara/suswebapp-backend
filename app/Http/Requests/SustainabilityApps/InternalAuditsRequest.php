<?php
namespace App\Http\Requests\SustainabilityApps;

use Illuminate\Foundation\Http\FormRequest;

class InternalAuditsRequest extends FormRequest
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
            'division'       => 'required|string|max:255',
            'department'     => 'nullable|string|max:255',
            'auditTitle'     => 'required|string|max:255',
            'auditType'      => 'required|string|max:255',
            'isNotSupplier'  => 'required|boolean',
            'factoryName'    => 'required|string|max:255',
            'factoryAddress' => 'required|string|max:255',
            'factoryContact' => 'required|string|max:255',
            'designation'    => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'contactNumber'  => 'required|string|max:15',
            'auditDate'      => 'nullable|date',
            'auditee'        => 'nullable|string|max:255',
            'approver'       => 'nullable|string|max:255',
            'dateApproval'   => 'nullable|date',
            'description'    => 'nullable|string',
            'supplierType'   => 'required_if:isNotSupplier,true|string|max:255',
            'factoryLiNo'    => 'required_if:isNotSupplier,true|string|max:255',
            'higgId'         => 'required_if:isNotSupplier,true|string|max:255',
            'zdhcId'         => 'required_if:isNotSupplier,true|string|max:255',
            'processType'    => 'required_if:isNotSupplier,true|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'division.required'        => 'Division is required',
            'auditTitle.required'      => 'Audit Title is required',
            'auditType.required'       => 'Audit Type is required',
            'isNotSupplier.required'   => 'Is Not Supplier is required',
            'factoryName.required'     => 'Factory Name is required',
            'factoryAddress.required'  => 'Factory Address is required',
            'factoryContact.required'  => 'Factory Contact is required',
            'designation.required'     => 'Designation is required',
            'email.required'           => 'Email is required',
            'contactNumber.required'   => 'Contact Number is required',
            'supplierType.required_if' => 'Supplier Type is required when the audit is a supplier audit.',
            'factoryLiNo.required_if'  => 'Factory License No is required when the audit is a supplier audit.',
            'higgId.required_if'       => 'Higg ID is required when the audit is a supplier audit.',
            'zdhcId.required_if'       => 'ZDHC ID is required when the audit is a supplier audit.',
            'processType.required_if'  => 'Process Type is required when the audit is a supplier audit.',
        ];
    }
}
