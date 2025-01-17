<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'issued_date',
        'is_no_expiry',
        'expiry_date',
        'notify_date',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
        'notify_date' => 'date',
    ];
}
