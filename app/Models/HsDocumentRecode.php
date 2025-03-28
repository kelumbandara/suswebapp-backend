<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsDocumentRecode extends Model
{
    use HasFactory;

    protected $table = 'hs_document_recodes';

    protected $fillable = [
        'documentNumber',
        'versionNumber',
        'documentType',
        'title',
        'division',
        'issuingAuthority',
        'issuedDate',
        'expiryDate',
        'notifyDate',
        'elapseDay',
        'status',
        'documentOwner',
        'documentReviewer',
        'physicalLocation',
        'remarks',
        'document',
        'isNoExpiry',
        'responsibleSection',
        'assigneeLevel',
        'createdByUser',
    ];

    protected $casts = [
        'isNoExpiry' => 'boolean',
        'document' => 'array',
    ];

}
