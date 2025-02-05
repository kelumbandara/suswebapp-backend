<?php
namespace App\Http\Requests\AccidentRecord;

use Illuminate\Foundation\Http\FormRequest;

class AccidentRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'division'                      => 'nullable|string',
            'location'                      => 'nullable|string',
            'department'                    => 'nullable|string',
            'supervisorName'                => 'nullable|string',
            'imageUrl'                      => 'nullable|string',
            'category'                      => 'nullable|string',
            'subCategory'                   => 'nullable|string',
            'accidentType'                  => 'nullable|string',
            'description'                   => 'nullable|string',
            'accidentDate'                  => 'nullable|date',
            'reportedDate'                  => 'nullable|date',
            'assignee'                      => 'nullable|string',
            'witnesses'                     => 'nullable|array',
            'witnesses.*.employeeId'        => 'nullable|string',
            'witnesses.*.employeeName'      => 'nullable|string',
            'witnesses.*.division'          => 'nullable|string',
            'witnesses.*.department'        => 'nullable|string',
            'people_involved'               => 'nullable|array',
            'people_involved.*.personType'  => 'nullable|string',
            'people_involved.*.employeeId'  => 'nullable|integer',
            'people_involved.*.personName'  => 'nullable|string',
            'people_involved.*.gender'      => 'nullable|string|in:male,female,other',
            'people_involved.*.age'         => 'nullable|integer|min:0',
            'people_involved.*.dateOfJoin'  => 'nullable|date',
            'people_involved.*.duration'    => 'nullable|integer',
            'people_involved.*.experience'  => 'nullable|string|in:skill,unskilled,semiskilled,draft',
            'people_involved.*.designation' => 'nullable|string|max:255',
        ];
    }

}
