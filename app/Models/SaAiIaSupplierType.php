<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaAiIaSupplierType extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplierTypeName',
    ];
}
