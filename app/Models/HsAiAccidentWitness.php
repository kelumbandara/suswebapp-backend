<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsAiAccidentWitness extends Model
{
    use HasFactory;

    protected $table = 'hs_ai_accident_witnesses';

    protected $primaryKey = 'witnessId';

    protected $fillable = [
        'accidentId',
        'employeeId',
        'employeeName',
        'division',
        'department',
    ];


    public function accident()
    {
        return $this->belongsTo(HsAiAccidentRecord::class, 'accidentId');
    }
}
