<?php

namespace App\Http\Requests\SaGrTopic;

use Illuminate\Foundation\Http\FormRequest;

class GrTopicRequest extends FormRequest
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
            'topicName' => 'required|string',
        ];
    }
}
