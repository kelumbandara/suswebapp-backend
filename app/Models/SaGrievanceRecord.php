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
        'employeeId',
        'location',
        'submissionDate',
        'isAnonymous',
        'channel',
        'category',
        'topic',
        'submissions',
        'description',
        'dueDate',
        'businessUnit',
        'resolutionDate',
        'remarks',
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
        'isIssuesPreviouslyRaised',
        'statementDocuments',
        'investigationCommitteeStatementDocuments',
        'evidence',
        'dateOfJoin',
        'servicePeriod',
        'tenureSplit',
        'designation',
        'department',
        'division',
        'assigneeId',
        'solutionRemark',
        'feedback',
        'stars',
        'status',
        'createdByUserId',
        'updatedByUserId',
        'openedByUserId',
        'inprogressByUserId',
        'completedByUserId',
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

       protected static function booted()
    {
        static::created(function ($model) {
            $year  = now()->year;
            $month = strtoupper(now()->format('M'));

            $model->updateQuietly([
                'referenceNumber' => 'GRI-' . $model->id,
                'caseId'          => "GRV/{$year}/{$month}/{$model->id}",
            ]);
        });
    }

}
