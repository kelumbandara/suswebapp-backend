<?php
namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add additional authorization logic if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'isCompanyEmployee' => ['required', 'boolean'],
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'min:4', 'confirmed'],
            'mobile'            => ['required', 'string', 'max:15', 'unique:users'],
            'department'        => ['nullable', 'string', 'max:255', 'required_if:isCompanyEmployee,true'],
            'jobPosition'       => ['nullable', 'string', 'required_if:isCompanyEmployee,true'],
            'assignedFactory'   => ['nullable', 'array', 'required_if:isCompanyEmployee,true'],
            'employeeNumber'    => ['nullable', 'string', 'max:255', 'unique:users', 'required_if:isCompanyEmployee,true'],

        ];
  
    }

    public function messages()
    {
        return [
            'name.required'               => 'Name is required',
            'email.required'              => 'Email is required',
            'email.unique'                => 'Email is already taken',
            'password.required'           => 'Password is required',
            'password.min'                => 'Password must be at least 4 characters.',
            'password.confirmed'          => 'Password confirmation does not match.',
            'mobile.required'             => 'Mobile is required',
            'mobile.unique'               => 'Mobile number already exists.',
            'employeeNumber.required_if'  => 'Employee number is required when the user is a company employee.',
            'assignedFactory.required_if' => 'Assigned factory is required when the user is a company employee.',
            'department.required_if'      => 'Department is required when the user is a company employee.',
            'employeeNumber.unique'       => 'Employee number already exists.',
            'jobPosition.required'        => 'Job position is required when the user is a company employee.',

        ];
    }
}
