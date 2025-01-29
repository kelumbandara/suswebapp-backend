<?php
namespace App\Http\Requests\HealthAndSafety;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'documentNumber'   => 'required|integer',
            'versionNumber'    => 'required|integer',
            'documentType'     => 'required|string',
            'title'            => 'required|string',
            'division'         => 'required|string',
            'issuingAuthority' => 'required|string',
            'documentOwner'    => 'nullable|string',
            'documentReviewer' => 'required|string',
            'physicalLocation' => 'nullable|string',
            'remarks'          => 'nullable|string',
            'document'         => 'nullable|string|max:2048',
            'issuedDate'       => 'required|date',
            'isNoExpiry'       => 'required|boolean',
            'expiryDate'       => 'nullable|date|required_if:isNoExpiry,false',
            'notifyDate'       => 'nullable|date|required_if:isNoExpiry,false',
            'createdDate'      => 'nullable|date',
            'createdBy'        => 'nullable|string',
        ];
    }
    /**
     * Customize the messages for validation failures.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'documentNumber.required'   => 'The document number is required.',
            'versionNumber.required'    => 'The version number is required.',
            'documentType.required'     => 'The document type is required.',
            'title.required'            => 'The title is required.',
            'division.required'         => 'The division is required.',
            'issuingAuthority.required' => 'The issuing authority is required.',
            'documentReviewer.required' => 'The document reviewer is required.',
            'issuedDate.required'       => 'The issued date is required.',
            'isNoExpiry.required'       => 'The is no expiry is required.',

        ];
    }
}
