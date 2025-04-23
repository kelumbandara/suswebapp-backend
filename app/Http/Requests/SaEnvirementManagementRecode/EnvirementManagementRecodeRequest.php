<?php
namespace App\Http\Requests\SaEnvirementManagementRecode;

use Illuminate\Foundation\Http\FormRequest;

class EnvirementManagementRecodeRequest extends FormRequest
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
            'totalWorkForce'                       => 'required|numeric',
            'numberOfDaysWorked'                   => 'required|numeric',
            'totalProductProducedPcs'              => 'required|numeric',
            'totalProductProducedKg'               => 'required|numeric',
            'division'                             => 'required|string',
            'year'                                 => 'nullable|string',
            'month'                                => 'nullable|string',
            'reviewerId'                           => 'required|string',
            'approverId'                           => 'nullable|string',
            'area'                                 => 'required|string',
            'createdByUser'                        => 'nullable|string',
            'impactConsumption'                    => 'nullable|array',
            'impactConsumption.*.category'         => 'required|string',
            'impactConsumption.*.source'           => 'required|string',
            'impactConsumption.*.unit'             => 'required|string',
            'impactConsumption.*.quantity'         => 'required|string',
            'impactConsumption.*.amount'           => 'required|string',
            'impactConsumption.*.ghgInTonnes'      => 'required|string',
            'impactConsumption.*.scope'            => 'required|string',
            'impactConsumption.*.methodOfTracking' => 'required|string',
            'impactConsumption.*.usageType'        => 'required|string',
            'impactConsumption.*.doYouHaveREC'     => 'required|boolean',
            'impactConsumption.*.description'      => 'nullable|string',
        ];
    }
}
