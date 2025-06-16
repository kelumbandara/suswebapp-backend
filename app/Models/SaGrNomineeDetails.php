<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaGrNomineeDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'nomineeId';

    protected $fillable = [
        'grievanceId',
        'employeeId',
        'name',
        'designation',
        'department',
    ];

    public function impact()
    {
        return $this->belongsTo(SaGrievanceRecord::class, 'grievanceId');
    }
}
