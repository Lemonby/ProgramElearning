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

    // Relationship ke Class (untuk members/students)
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relationship ke Attendances (untuk members)
    public function attendances()
    {
        return $this->hasMany(Attendances::class, 'member_id');
    }

    // Relationship ke Meetings yang dipandu mentor
    public function mentorMeetings()
    {
        return $this->hasMany(Meeting::class, 'mentor_id');
    }

    // Relationship ke Attendances yang dicatat mentor
    public function recordedAttendances()
    {
        return $this->hasMany(Attendances::class, 'input_by');
    }

    // Helper method untuk check role
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    public function isMember()
    {
        return $this->role === 'member' || $this->role === 'student';
    }
}