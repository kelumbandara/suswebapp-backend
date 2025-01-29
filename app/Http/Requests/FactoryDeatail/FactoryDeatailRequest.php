<?php
namespace App\Http\Requests\FactoryDeatail;

use Illuminate\Foundation\Http\FormRequest;

class FactoryDeatailRequest extends FormRequest
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
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:factory_deatails,email',
            'contact_number' => 'required|string|max:15',
            'address'        => 'required|string|max:500',
            'designation'    => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required'           => 'Name is required',
            'email.required'          => 'Email is required',
            'contact_number.required' => 'Contact Number is required',
            'address.required'        => 'Address is required',
            'designation.required'    => 'Designation is required',
            'contact_person.required' => 'Contact Person is required',
        ];
    }
}
