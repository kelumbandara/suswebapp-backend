<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryPerson extends Model
{
    use HasFactory;

    protected $table = 'factory_people';
    protected $fillable = [
        'name',
    ];
}
