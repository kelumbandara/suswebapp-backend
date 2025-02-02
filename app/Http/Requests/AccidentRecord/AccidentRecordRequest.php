<?php

namespace App\Http\Requests\AccidentRecord;

use Illuminate\Foundation\Http\FormRequest;

class AccidentRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division' => 'required|string',
            'location' => 'required|string',
            'department' => 'nullable|string',
            'supervisorName' => 'required|string',
            'imageUrl' => 'nullable|string',
            'category' => 'required|string',
            'subCategory' => 'required|string',
            'accidentType' => 'required|string',
            'affectedPrimaryRegion' => 'nullable|string',
            'affectedSecondaryRegion' => 'nullable|string',
            'affectedTertiaryRegion' => 'nullable|string',
            'injuryCause' => 'nullable|string',
            'consultedHospital' => 'nullable|string',
            'consultedDoctor' => 'nullable|string',
            'description' => 'required|string',
            'workPerformed' => 'nullable|string',
            'actionTaken' => 'nullable|string',
            'accidentDate' => 'required|date',
            'accidentTime' => 'nullable|time',
            'reportedDate' => 'nullable|date',
            'injuryType' => 'nullable|string',
            'severity' => 'nullable|string',
            'assignee' => 'required|string',
            'expectedDate' => 'nullable|date',
            'expectedTime' => 'nullable|time',
        ];
    }
}
