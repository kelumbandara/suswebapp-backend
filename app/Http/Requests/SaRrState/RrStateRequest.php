<?php
namespace App\Http\Requests\SaRrState;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RrStateRequest extends FormRequest
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
            'countryId' => 'required|integer',
            'stateName' => [
                'required',
                'string',
                Rule::unique('sa_rr_states')->where(function ($query) {
                    return $query->where('countryId', $this->countryId);
                }),
            ],
        ];
    }

}
