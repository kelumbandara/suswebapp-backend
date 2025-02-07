<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsDocumentDocumentType extends Model
{
    use HasFactory;

    protected $table = 'hs_document_document_types';

    protected $fillable = [
        'documentType',
    ];
}
