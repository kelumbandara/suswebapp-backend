<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhCsClinicalSuite extends Model
{
    use HasFactory;
    protected $fillable = [
        'patientId',
        'employeeId',
        'employeeName',
        'designation',
        'gender',
        'age',
        'department',
        'SubDepartment',
        'division',
        'workStatus',
        'symptoms',
        'checkInDate',
        'checkInTime',
        'checkOut',
        'bodyTemperature',
        'weight',
        'height',
        'useFeetAndInches',
        'feet',
        'inches',
        'bloodPressure',
        'randomBloodSugar',
        'consultingDoctor',
        'clinicDivision',
        'status',
        'createdByUser',
        'assigneeLevel',
        'responsibleSection',
    ];

}
