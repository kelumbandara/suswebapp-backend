<?php
namespace App\Http\Requests\SaAiExternalAudit;

use Illuminate\Foundation\Http\FormRequest;

class ExternalAuditRequest extends FormRequest
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
            'auditType'       => 'required|string',
            'auditCategory'   => 'required|string',
            'auditStandard'   => 'required|string',
            'customer'        => 'required|string',
            'auditFirm'       => 'required|string',
            'division'        => 'required|string',
            'auditDate'       => 'nullable|string',
            'approvalDate'    => 'required|string',
            'approverId'      => 'required|string',
            'representor'     => 'required|string',
            'announcement'    => 'nullable|string',
            'assessmentDate'  => 'nullable|string',
            'auditorId'       => 'nullable|string',
            'remarks'         => 'nullable|string',
            'auditorName'     => 'nullable|string',
            'auditExpiryDate' => 'nullable|string',
            'auditStatus'     => 'nullable|string',
            'auditScore'      => 'nullable|string',
            'gradePeriod'     => 'nullable|string',
            'numberOfNonCom'  => 'nullable|string',
            'auditFee'        => 'nullable|string',
            'auditGrade'      => 'nullable|string',
            'removeDoc'       => 'nullable|array',
            'documents'       => 'nullable|array',
            'documents.*'     => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
        ];
    }
}
