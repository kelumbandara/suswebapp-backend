<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMiPiSupplierName extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplierName',
    ];
}
