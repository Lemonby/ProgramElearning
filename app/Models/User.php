<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'class_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendances::class, 'member_id');
    }

    public function mentorMeetings()
    {
        return $this->hasMany(Meeting::class, 'mentor_id');
    }
}