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
            'division'                      => 'required|string',
            'location'                      => 'required|string',
            'department'                    => 'nullable|string',
            'supervisorName'                => 'required|string',
            'imageUrl'                      => 'nullable|string',
            'category'                      => 'required|string',
            'subCategory'                   => 'required|string',
            'accidentType'                  => 'required|string',
            'description'                   => 'required|string',
            'accidentDate'                  => 'required|date',
            'reportedDate'                  => 'nullable|date',
            'assignee'                      => 'required|string',
            'witnesses'                     => 'nullable|array',
            'witnesses.*.employeeId'        => 'required|string',
            'witnesses.*.employeeName'      => 'required|string',
            'witnesses.*.division'          => 'required|string',
            'witnesses.*.department'        => 'nullable|string',
            'people_involved'               => 'nullable|array',
            'people_involved.*.personType'  => 'required|string',
            'people_involved.*.employeeId'  => 'nullable|integer',
            'people_involved.*.personName'  => 'required|string',
            'people_involved.*.gender'      => 'nullable|string|in:male,female,other',
            'people_involved.*.age'         => 'required|integer|min:0',
            'people_involved.*.dateOfJoin'  => 'nullable|date',
            'people_involved.*.duration'    => 'nullable|integer',
            'people_involved.*.experience'  => 'nullable|string|in:skill,unskilled,semiskilled,draft',
            'people_involved.*.designation' => 'nullable|string|max:255',
        ];
    }

}
