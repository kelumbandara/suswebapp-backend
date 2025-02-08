<?php

namespace App\Http\Requests\HsOhCsMedicineStock;

use Illuminate\Foundation\Http\FormRequest;

class MedicineStockRequest extends FormRequest
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
            'medicineName' => 'required|string',
            'division' => 'nullable|string',
            'inStock' => 'required|string',
            'status' => 'nullable|string',
            'lastUpdated' => 'nullable|string',
        ];
    }
}
