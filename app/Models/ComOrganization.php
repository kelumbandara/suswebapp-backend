<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComOrganization extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizationName',
        'documents',
        'createdByUser',
        'updatedBy',
    ];

    protected $casts = [
        'documents' => 'array',
    ];
}
