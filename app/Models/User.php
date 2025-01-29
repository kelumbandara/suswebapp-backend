<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'IsCompanyEmployee',
        'employeeNumber',
        'mobile',
        'emailVerifiedAt',
        'userType',
        'department',
        'jobPosition',
        'ResponsibleSection',
        'profileImage',
        'availability',
        'assignedFactory',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'ResponsibleSection' => 'array',
        'assignedFactory' => 'array',
    ];
    public function setAssignFactoryAttribute($value)
    {
        $this->attributes['assignedFactory'] = json_encode($value);
        $this->attributes['ResponsibleSection'] = json_encode($value);
    }

    // Accessor to retrieve assignFactory as an array
    public function getAssignFactoryAttribute($value)
    {
        return json_decode($value, true);
    }
}
