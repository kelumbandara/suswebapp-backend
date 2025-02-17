<?php
namespace App\Http\Requests\HsOhMiMedicineName;

use Illuminate\Foundation\Http\FormRequest;

class MedicineNameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'medicineName'   => 'required|string',
            'genericName'    => 'nullable|string',
            'dosageStrength' => 'nullable|string',
            'form'           => 'nullable|string',
            'medicineType'   => 'nullable|string',
        ];

    }
}
