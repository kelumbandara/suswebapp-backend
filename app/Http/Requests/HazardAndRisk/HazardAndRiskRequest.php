<?php
namespace App\Http\Requests\HazardAndRisk;

use Illuminate\Foundation\Http\FormRequest;

class HazardAndRiskRequest extends FormRequest
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
            'category'             => 'required|string|max:255',
            'subCategory'          => 'required|string|max:255',
            'observationType'      => 'nullable|string|max:255',
            'division'             => 'required|string|max:255',
            'assigneeId'           => 'required|string',
            'locationOrDepartment' => 'required|string|max:255',
            'subLocation'          => 'nullable|string|max:255',
            'description'          => 'nullable|string|max:1025',
            'documents'            => 'nullable|array',
            'documents.*'          => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'dueDate'              => 'nullable|string',
            'condition'            => 'nullable|string|max:255',
            'riskLevel'            => 'nullable|string|max:255',
            'unsafeActOrCondition' => 'nullable|in:Unsafe Act,Unsafe Condition',
            'serverDateAndTime'    => 'nullable|string',
            'assigneeLevel'        => 'nullable|integer',
            'responsibleSection'   => 'nullable|string|max:255',
            'createdByUser'        => 'nullable|string|max:255',

        ];
    }
}
