<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HSDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'document_number',
        'version_number',
        'document_type',
        'title',
        'division',
        'issuing_authority',
        'document_owner',
        'document_reviewer',
        'physical_location',
        'remarks',
        'document',
        'issued_date',
        'is_no_expiry',
        'expiry_date',
        'notify_date',
        'created_date',
        'created_by',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
        'notify_date' => 'date',
        'created_date' => 'date',
        'document' => 'array',
    ];
    public function getStatusAttribute()
    {
        if ($this->is_no_expiry || !$this->expiry_date) {
            return 'Active'; 
        }

        $expiryDate = Carbon::parse($this->expiry_date);
        $now = Carbon::now();

        return $expiryDate->isFuture() ? 'Active' : 'Expired';
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($document) {
            if ($document->is_no_expiry || !$document->expiry_date) {
                $document->status = 'Active';
            } else {
                $expiryDate = Carbon::parse($document->expiry_date);
                $document->status = $expiryDate->isFuture() ? 'Active' : 'Expired';
            }
        });
    }
}
