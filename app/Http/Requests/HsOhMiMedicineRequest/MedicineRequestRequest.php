<?php
namespace App\Http\Requests\HsOhMiMedicineRequest;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequestRequest extends FormRequest
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
            'medicineName'    => 'required|string',
            'genericName'     => 'required|string',
            'approver'        => 'required|string',
            'division'        => 'required|string',
            'requestQuantity' => 'required|integer',
        ];
    }
}
