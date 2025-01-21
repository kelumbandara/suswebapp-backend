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
            'division' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'audit_title' => 'required|string|max:255',
            'audit_type' => 'required|string|max:255',
            'is_supplier_audit' => 'required|boolean',
            'factory_name' => 'required|string|max:255',
            'factory_address' => 'required|string|max:255',
            'factory_contact_person' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:15',
            'audit_date' => 'nullable|date',
            'auditee' => 'nullable|string|max:255',
            'approver' => 'nullable|string|max:255',
            'approval_date' => 'nullable|date',
            'description' => 'nullable|string',
            'supplier_type' => 'required_if:is_supplier_audit,true|string|max:255',
            'factory_license_no' => 'required_if:is_supplier_audit,true|string|max:255',
            'higg_id' => 'required_if:is_supplier_audit,true|string|max:255',
            'zdhc_id' => 'required_if:is_supplier_audit,true|string|max:255',
            'process_type' => 'required_if:is_supplier_audit,true|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'supplier_type.required_if' => 'Supplier Type is required when the audit is a supplier audit.',
            'factory_license_no.required_if' => 'Factory License No is required when the audit is a supplier audit.',
            'higg_id.required_if' => 'Higg ID is required when the audit is a supplier audit.',
            'zdhc_id.required_if' => 'ZDHC ID is required when the audit is a supplier audit.',
            'process_type.required_if' => 'Process Type is required when the audit is a supplier audit.',
        ];
    }
}
