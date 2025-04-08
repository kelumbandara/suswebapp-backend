<?php

namespace App\Http\Requests\SaAiIaQuestionRecode;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRecodeRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'createdByUser' => 'nullable|string',
            'impactGroup' => 'required|array',
            'impactGroup.*.groupName' => 'required|string',
            'impactGroup.*.impactQuection' => 'required|array',
            'impactGroup.*.impactQuection.*.colorCode' => 'required|string',
            'impactGroup.*.impactQuection.*.question' => 'required|string',
            'impactGroup.*.impactQuection.*.allocatedScore' => 'required|integer',
        ];
    }
}
