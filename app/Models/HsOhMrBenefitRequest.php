<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMrBenefitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
'employeeId',
        'employeeName',
        'applicationId',
        'applicationDate',
        'reJoinDate',
        'status',
        'age',
        'contactNumber',
        'designation',
        'department',
        'supervisorOrManager',
        'dateOfJoin',
        'averageWages',
        'division',
        'remarks',
        'expectedDeliveryDate',
        'leaveStatus',
        'leaveStartDate',
        'leaveEndDate',
        'actualDeliveryDate',
        'noticeDateAfterDelivery',
        'supportProvider',
        'createdByUser',
        'responsibleSection',
        'assigneeLevel',
    ];

}
