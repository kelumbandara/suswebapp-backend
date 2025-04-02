<?php
namespace App\Http\Requests\SaSrSDGReportRecode;

use Illuminate\Foundation\Http\FormRequest;

class SDGReportRecodeRequest extends FormRequest
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
            'title'                      => 'required|string',
            'location'                   => 'required|string',
            'division'                   => 'required|string',
            'pillars'                    => 'required|array',
            'timeLines'                  => 'nullable|string',
            'materialityType'            => 'required|array',
            'materialityIssue'           => 'required|array',
            'sdg'                        => 'required|string',
            'additionalSdg'              => 'nullable|array',
            'alignmentSdg'               => 'required|string',
            'griStandards'               => 'nullable|string',
            'organizer'                  => 'required|string',
            'volunteer'                  => 'required|string',
            'priority'                   => 'nullable|string',
            'contributing'               => 'nullable|string',
            'removeDoc'                  => 'nullable|array',
            'documents'                  => 'nullable|array',
            'documents.*'                => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'impactDetails'              => 'required|array',
            'impactDetails.*.impactType' => 'required|string',
            'impactDetails.*.unit'       => 'required|string',
            'impactDetails.*.value'      => 'required|string',
        ];
    }
}
