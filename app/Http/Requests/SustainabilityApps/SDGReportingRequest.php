<?php
namespace App\Http\Requests\SustainabilityApps;

use Illuminate\Foundation\Http\FormRequest;

class SDGReportingRequest extends FormRequest
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
            'title'                  => 'required|string|max:255',
            'location'               => 'required|string|max:255',
            'division'               => 'required|string|max:255',
            'pillar'                 => 'required|string|max:255',
            'timeLine'               => 'nullable|string|max:255',
            'materialType'           => 'required|string|max:255',
            'materialIssue'          => 'required|string|max:255',
            'sdg'                    => 'required|string|max:255',
            'additionalSDGs'         => 'nullable|string|max:255',
            'griAndSubStandards'     => 'nullable|string|max:255',
            'organiser'              => 'required|string|max:255',
            'volunteersParticipants' => 'required|integer|min:1',
            'priority'               => 'nullable|string|max:255',
            'contributing'           => 'nullable|string|max:255',
            'image_path'             => 'nullable|string|max:2048',
        ];

    }
    public function messages(): array
    {
        return [
            'title.required'                  => 'The title is required.',
            'location.required'               => 'The location is required.',
            'division.required'               => 'The division is required.',
            'pillar.required'                 => 'The pillar is required.',
            'materialType.required'           => 'The material type is required.',
            'materialIssue.required'          => 'The material issue is required.',
            'sdg.required'                    => 'The SDG is required.',
            'organiser.required'              => 'The organiser is required.',
            'volunteersParticipants.required' => 'The volunteers participants is required.',
            'volunteersParticipants.integer'  => 'Participants must be a number.',
            'image_path.image'                => 'The file must be an image.',
        ];
    }
}
