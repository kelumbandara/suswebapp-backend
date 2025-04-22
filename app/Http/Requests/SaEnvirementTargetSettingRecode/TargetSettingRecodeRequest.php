<?php
namespace App\Http\Requests\SaEnvirementTargetSettingRecode;

use Illuminate\Foundation\Http\FormRequest;

class TargetSettingRecodeRequest extends FormRequest
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
            'division'            => 'required|string',
            'department'          => 'required|string',
            'category'            => 'required|string',
            'source'              => 'required|string',
            'baselineConsumption' => 'required|numeric',
            'ghgEmission'         => 'required|numeric',
            'problem'             => 'nullable|string',
            'documents'           => 'nullable|array',
            'documents.*'         => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'responsibleId'       => 'required|string',
            'approverId'          => 'required|string',
            'action'              => 'nullable|string',
            'possibilityCategory' => 'required|string',
            'opertunity'          => 'nullable|string',
            'implementationCost'  => 'required|numeric',
            'expectedSavings'     => 'required|numeric',
            'targetGHGReduction'  => 'required|numeric',
            'costSavings'         => 'required|numeric',
            'implementationTime'  => 'nullable|string',
            'paybackPeriod'       => 'required|numeric',
            'projectLifespan'     => 'required|numeric',
            'createdByUser'       => 'nullable|string',
        ];
    }
}
