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
            'category'             => 'nullable|string|max:255',
            'subCategory'          => 'nullable|string|max:255',
            'observationType'      => 'nullable|string|max:255',
            'division'             => 'nullable|string|max:255',
            'assignee'             => 'nullable|string|max:255',
            'locationOrDepartment' => 'nullable|string|max:255',
            'subLocation'          => 'nullable|string|max:255',
            'description'          => 'nullable|string',
            'documents'            => 'nullable|string|max:255',
            'dueDate'              => 'nullable|string',
            'condition'            => 'nullable|string|max:255',
            'riskLevel'            => 'nullable|string|max:255',
            'unsafeActOrCondition' => 'nullable|in:Unsafe Act,Unsafe Condition',
            'serverDateAndTime'    => 'nullable|string',
            'assigneeLevel'        => 'nullable|integer',
            'responsibleSection'   => 'nullable|string|max:255',

        ];
    }
}
