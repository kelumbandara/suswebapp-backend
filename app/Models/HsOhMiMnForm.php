<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsOhMiMnForm extends Model
{
    use HasFactory;

    protected $table = 'hs_oh_mi_mn_forms'; // Explicitly define the table name

    protected $fillable = [
        'Name',
    ];
}
