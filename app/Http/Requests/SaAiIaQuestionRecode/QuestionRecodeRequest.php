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
            'questionGroups' => 'nullable|array',
            'questionGroups.*.groupName' => 'required|string',
            'questionGroups.*.questions' => 'nullable|array',
            'questionGroups.*.questions.*.colorCode' => 'required|string',
            'questionGroups.*.questions.*.question' => 'required|string',
            'questionGroups.*.questions.*.allocatedScore' => 'required|integer',
        ];
    }
}
