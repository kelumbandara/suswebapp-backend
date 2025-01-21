<?php

namespace App\Http\Requests\HealthAndSafety;

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
            'division' => 'required|string|max:255',
            'locationOrDepartment' => 'required|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'description' => 'required|string',
            'riskLevel' => 'required|in:Low,Medium,High',
            'unsafeActOrCondition' => 'required|in:Unsafe Act,Unsafe Condition',
            'createdByUser' => 'nullable|string|max:255',
            'dueDate' => 'nullable|date',
            'assignee' => 'nullable|string|max:255',
            'document' => 'nullable|string|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'division.required' => 'Division is required.',
            'locationOrDepartment.required' => 'Location or department is required.',
            // Other custom messages
        ];
    }
}
