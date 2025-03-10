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

    protected function prepareForValidation()
    {
        $this->merge([
            'isNoExpiry' => filter_var($this->isNoExpiry, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
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
            'document'        => 'nullable|array',
            'document.*'      => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'issuedDate'       => 'required|string',
            'isNoExpiry'       => 'nullable|boolean',
            'expiryDate'       => 'required_if:isNoExpiry,false|string',
            'notifyDate'       => 'required_if:isNoExpiry,false|string',

        ];
    }
}
