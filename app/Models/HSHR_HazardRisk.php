<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HSHR_HazardRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'division',
        'locationOrDepartment',
        'subLocation',
        'category',
        'subCategory',
        'observationType',
        'description',
        'riskLevel',
        'unsafeActOrCondition',
        'status',
        'createdByUser',
        'createdDate',
        'dueDate',
        'assignee',
        'document',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'dueDate' => 'datetime',
    ];

    const RISK_LEVELS = ['Low', 'Medium', 'High'];
    const UNSAFE_ACT_CONDITIONS = ['Unsafe Act', 'Unsafe Condition'];
    const STATUSES = ['draft', 'approved', 'declined'];

    protected static function booted()
    {
        static::creating(function ($hazardRisk) {
            $maxId = HSHR_HazardRisk::max('id') + 1;
            $hazardRisk->reference_id = 'EHS-' . $maxId;

            if ($hazardRisk->status === null) {
                $hazardRisk->status = 'draft';
            }
        });
    }

    public function getRiskLevelAttribute($value)
    {
        return strtolower($value);
    }

    public function getUnsafeActOrConditionAttribute($value)
    {
        return strtolower($value);
    }

    public function getStatusAttribute($value)
    {
        return strtolower($value);
    }

    public function setRiskLevelAttribute($value)
    {
        $this->attributes['riskLevel'] = strtolower($value);
    }

    public function setUnsafeActOrConditionAttribute($value)
    {
        $this->attributes['unsafeActOrCondition'] = strtolower($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }
}
