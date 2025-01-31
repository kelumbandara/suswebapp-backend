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
            'categoryName' => 'required|string|max:255',
            'subCategory' => 'nullable|string|max:255',
            'observationType' => 'nullable|string|max:255',
            'divisionName' => 'nullable|string|max:255',
            'assigneeName' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'subLocation' => 'nullable|string|max:255',
            'description' => 'required|string',
            'fileUrl' => 'nullable|url',
            'dueDate' => 'nullable|date',
            'condition' => 'nullable|string|max:255',
            'riskLevel' => 'nullable|string|max:255',
            'unsafeType' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'serverDateAndTime' => 'required|date',
            'assigneeLevel' => 'required|integer',
            'responsibleSection' => 'required|string|max:255',
        ];
    }
}
