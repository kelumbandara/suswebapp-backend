<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaGrievanceRecord extends Model
{
    use HasFactory;


    protected $fillable = [
        'referenceNumber',
        'caseId',
        'type',
        'personType',
        'name',
        'gender',
        'supervisor',
        'employeeShift',
        'location',
        'submissionDate',
        'isAnonymous',
        'channel',
        'category',
        'topic',
        'submission',
        'description',
        'dueDate',
        'BusinessUnit',
        'resolutionDate',
        'remark',
        'helpDeskPerson',
        'responsibleDepartment',
        'humanRightsViolation',
        'frequencyRate',
        'severityScore',
        'scale',
        'committeeStatement',
        'grievantStatement',
        'tradeUnionRepresentative',
        'isFollowUp',
        'isAppeal',
        'solutionProvided',
        'isIssuesPreviouslyRaised ',
        'statementDocuments',
        'investigationCommitteeStatementDocuments',
        'evidence',
        'dateOfJoin',
        'servicePeriod',
        'tenureSplit',
        'designation',
        'department',
        'feedback',
        'stars',
        'status',
        'rejectedBy',
        'approvedBy',
        'createdByUser',
        'updatedBy',
        'inprogressBy',
        'publishedBy',
        'completedBy',
    ];

    protected $casts = [
        'isAnonymous' => 'boolean',
        'isFollowUp' => 'boolean',
        'isAppeal' => 'boolean',
        'isIssuesPreviouslyRaised' => 'boolean',
        'statementDocuments' => 'array',
        'investigationCommitteeStatementDocuments' => 'array',
        'evidence' => 'array',
    ];
}
