<?php
namespace App\Http\Requests\SaAiInternalAuditFactory;

use Illuminate\Foundation\Http\FormRequest;

class InternalAuditFactoryRequest extends FormRequest
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
            'factoryName'              => 'required|string',
            'factoryAddress'           => 'required|string',
            'factoryContactNumber'     => 'required|string',
            'factoryEmail'             => 'required|string',
            'designation'              => 'required|string',
            'factoryContactPersonId'   => 'required|numeric',
            'factoryContactPersonName' => 'required|string',

        ];
    }
}
