<?php

namespace App\Http\Requests\SustainabilityApps;

use Illuminate\Foundation\Http\FormRequest;

class ExternalAuditsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Modify based on your authorization logic
    }

    /**
     * Define validation rules.
     */
    public function rules(): array
    {
        return [
            'auditorName' => 'required|string|max:255',
            'auditType' => 'required|string|max:255',
            'auditCategory' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'auditStandard' => 'required|string|max:255',
            'auditFirm' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'representative' => 'required|string|max:255',
            'auditDate' => 'required|date|date_format:Y-m-d',
            'expiryDate' => 'nullable|date|date_format:Y-m-d|after_or_equal:auditDate',
            'approver' => 'required|string|max:255',
            'announcement' => 'nullable|string|max:255',
            'dateApproval' => 'nullable|date|date_format:Y-m-d',
            'description' => 'nullable|string',
            'lapsedStatus' => 'nullable|string|max:255',
            'auditStatus' => 'nullable|string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'auditorName.required' => 'The auditor name is required.',
            'auditType.required' => 'The audit type is required.',
            'auditCategory.required' => 'The audit category is required.',
            'customer.required' => 'The customer is required.',
            'auditStandard.required' => 'The audit standard is required.',
            'auditFirm.required' => 'The audit firm is required.',
            'division.required' => 'The division is required.',
            'representative.required' => 'The representative is required.',
            'auditDate.required' => 'The audit date is required.',
            'expiryDate.after_or_equal' => 'The expiry date must be on or after the audit date.',
            'approver.required' => 'The approver is required.',
        ];
    }
}
