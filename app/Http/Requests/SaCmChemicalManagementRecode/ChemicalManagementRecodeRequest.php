<?php
namespace App\Http\Requests\SaCmChemicalManagementRecode;

use Illuminate\Foundation\Http\FormRequest;

class ChemicalManagementRecodeRequest extends FormRequest
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
            'commercialName'          => 'required|string',
            'substanceName'           => 'nullable|string',
            'reachRegistrationNumber' => 'nullable|string',
            'molecularFormula'        => 'nullable|string',
            'requestQuantity'         => 'required|string',
            'requestUnit'             => 'required|string',
            'zdhcCategory'            => 'required|string',
            'chemicalFormType'        => 'required|string',
            'whareAndWhyUse'          => 'required|string',
            'productStandard'         => 'required|string',
            'doYouHaveMSDSorSDS'      => 'nullable|boolean',
            'division'                => 'required|string',
            'requestedCustomer'       => 'nullable|string',
            'requestedMerchandiser'   => 'nullable|string',
            'requestDate'             => 'required|string',
            'reviewerId'              => 'required|string',
        ];
    }
}
