<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComAssigneeLevel extends Model
{
    use HasFactory;

    protected $table = 'com_assignee_level';

    protected $fillable = [
        'levelId',
        'levelName',
    ];
}
