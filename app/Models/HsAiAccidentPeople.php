<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiAccidentPeople extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_accident_people';

    protected $primaryKey = 'personId';

    protected $fillable = [
        'accidentId',
        'personType',
        'employeeId',
        'personName',
        'gender',
        'age',
        'dateOfJoin',
        'duration',
        'experience',
        'designation',
    ];

    /**
     * Relationship with the accident record (assuming the foreign key is `accidentId`).
     */
    public function accident()
    {
        return $this->belongsTo(HsAiAccidentRecord::class, 'accidentId');
    }
}

