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
        'documentNumber',
        'versionNumber',
        'documentType',
        'title',
        'division',
        'issuingAuthority',
        'documentOwner',
        'documentReviewer',
        'physicalLocation',
        'remarks',
        'document',
        'issuedDate',
        'isNoExpiry',
        'expiryDate',
        'notifyDate',
        'createdDate',
        'createdBy',
    ];

    protected $casts = [
        'issuedDate' => 'date',
        'expiryDate' => 'date',
        'notifyDate' => 'date',
        'createdDate' => 'date',
        'document' => 'array',
    ];
    public function getStatusAttribute()
    {
        if ($this->isNoExpiry || !$this->expiryDate) {
            return 'Active';
        }

        $expiryDate = Carbon::parse($this->expiryDate);
        $now = Carbon::now();

        return $expiryDate->isFuture() ? 'Active' : 'Expired';
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($document) {
            if ($document->isNoExpiry || !$document->expiryDate) {
                $document->status = 'Active';
            } else {
                $expiryDate = Carbon::parse($document->expiryDate);
                $document->status = $expiryDate->isFuture() ? 'Active' : 'Expired';
            }
        });
    }
}
