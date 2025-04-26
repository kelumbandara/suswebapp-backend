<?php
namespace App\Http\Requests\SaAiIarActionPlane;

use Illuminate\Foundation\Http\FormRequest;

class ActionPlaneRequest extends FormRequest
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
            'correctiveOrPreventiveAction' => 'required|string',
            'priority'                     => 'required|string',
            'approverId'                   => 'required|numeric',
            'targetCompletionDate'         => 'nullable|string',
            'dueDate'                      => 'nullable|string',
        ];
    }
}
