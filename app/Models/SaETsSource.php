<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaETsSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'sourceName',
    ];
}
