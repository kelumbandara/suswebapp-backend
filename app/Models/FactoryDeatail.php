<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactoryDeatail extends Model
{
    use HasFactory;

    protected $table = 'factory_deatails';

    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'address',
        'designation',
        'contact_person',
    ];


}
