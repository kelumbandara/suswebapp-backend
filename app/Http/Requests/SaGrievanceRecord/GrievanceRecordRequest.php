<?php
namespace App\Http\Requests\SaGrievanceRecord;

use Illuminate\Foundation\Http\FormRequest;

class GrievanceRecordRequest extends FormRequest
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
            'type'                                           => 'required|string',
            'personType'                                     => 'required|string',
            'name'                                           => 'required|string',
            'gender'                                         => 'required|string',
            'supervisorId'                                   => 'nullable|integer',
            'employeeShift'                                  => 'required|string',
            'employeeId'                                     => 'required|string',
            'location'                                       => 'nullable|string',
            'submissionDate'                                 => 'nullable|string',
            'isAnonymous'                                    => 'boolean|nullable',
            'channel'                                        => 'required|string',
            'category'                                       => 'required|string',
            'topic'                                          => 'nullable|string',
            'submissions'                                    => 'required|string',
            'description'                                    => 'nullable|string',
            'dueDate'                                        => 'nullable|string',
            'businessUnit'                                   => 'required|string',
            'resolutionDate'                                 => 'nullable|string',
            'remarks'                                        => 'nullable|string',
            'helpDeskPerson'                                 => 'nullable|string',
            'responsibleDepartment'                          => 'required|string',
            'humanRightsViolation'                           => 'nullable|string',
            'frequencyRate'                                  => 'nullable|string',
            'severityScore'                                  => 'nullable|string',
            'scale'                                          => 'nullable|string',
            'committeeStatement'                             => 'nullable|string',
            'grievantStatement'                              => 'nullable|string',
            'tradeUnionRepresentative'                       => 'nullable|string',
            'isFollowUp'                                     => 'boolean|nullable',
            'isAppeal'                                       => 'boolean|nullable',
            'solutionProvided'                               => 'nullable|string',
            'isIssuesPreviouslyRaised'                       => 'boolean|nullable',
            'removeStatementDocuments'                       => 'nullable|array',
            'statementDocuments'                             => 'nullable|array',
            'statementDocuments.*'                           => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'removeInvestigationCommitteeStatementDocuments' => 'nullable|array',
            'investigationCommitteeStatementDocuments'       => 'nullable|array',
            'investigationCommitteeStatementDocuments.*'     => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'removeEvidence'                                 => 'nullable|array',
            'evidence'                                       => 'nullable|array',
            'evidence.*'                                     => 'file|mimes:pdf,doc,docx,xlsx,ppt,pptx,jpg,jpeg,png,gif,zip,webp',
            'dateOfJoin'                                     => 'nullable|string',
            'servicePeriod'                                  => 'nullable|string',
            'tenureSplit'                                    => 'nullable|string',
            'designation'                                    => 'nullable|string',
            'department'                                     => 'nullable|string',
            'division'                                       => 'nullable|string',
            'status'                                         => 'nullable|string',
            'rejectedBy'                                     => 'nullable|integer',
            'approvedBy'                                     => 'nullable|integer',
            'createdByUser'                                  => 'nullable|integer',
            'updatedBy'                                      => 'nullable|integer',
            'inprogressBy'                                   => 'nullable|integer',
            'publishedBy'                                    => 'nullable|integer',
            'completedBy'                                    => 'nullable|integer',

            'committeeMembers'                               => 'nullable|array',
            'committeeMembers.*.grievanceId'                 => 'nullable|integer',
            'committeeMembers.*.employeeId'                  => 'required|string',
            'committeeMembers.*.name'                        => 'required|string',
            'committeeMembers.*.designation'                 => 'required|string',
            'committeeMembers.*.department'                  => 'required|string',

            'legalAdvisors'                                  => 'nullable|array',
            'committeeMembers.*.grievanceId'                 => 'nullable|integer',
            'legalAdvisors.*.email'                          => 'required|email',
            'legalAdvisors.*.name'                           => 'required|string',
            'legalAdvisors.*.phone'                          => 'required|numeric',

            'nominees'                                       => 'nullable|array',
            'committeeMembers.*.grievanceId'                 => 'nullable|integer',
            'nominees.*.employeeId'                          => 'required|string',
            'nominees.*.name'                                => 'required|string',
            'nominees.*.designation'                         => 'required|string',
            'nominees.*.department'                          => 'required|string',

            'respondents'                                    => 'nullable|array',
            'committeeMembers.*.grievanceId'                 => 'nullable|integer',
            'respondents.*.employeeId'                       => 'required|string',
            'respondents.*.name'                             => 'required|string',
            'respondents.*.designation'                      => 'required|string',
            'respondents.*.department'                       => 'required|string',
        ];
    }
}
