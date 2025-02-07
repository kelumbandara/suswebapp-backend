<?php
namespace App\Http\Requests\HsDocumentRecode;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRecodeRequest extends FormRequest
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
            'documentType'     => 'required|string',
            'division'         => 'required|string',
            'issuingAuthority' => 'required|string',
            'documentNumber'   => 'required|string',
            'title'            => 'required|string',
            'documentOwner'    => 'nullable|string',
            'documentReviewer' => 'required|string',
            'physicalLocation' => 'nullable|string',
            'versionNumber'    => 'required|string',
            'remarks'          => 'nullable|string',
            'document'         => 'required|string',
            'issuedDate'       => 'required|string',
            'noExpiry'         => 'nullable|boolean',
            'expiryDate'       => 'required_if:noExpiry,true|string',
            'notifyDate'       => 'required_if:noExpiry,true|string',
        ];
    }
}
