<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaGrLegalAdvisorDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'legalAdvisorId';

    protected $fillable = [
        'grievanceId',
        'email',
        'name',
        'phone',
    ];

    public function impact()
    {
        return $this->belongsTo(SaGrievanceRecord::class, 'grievanceId');
    }
}
