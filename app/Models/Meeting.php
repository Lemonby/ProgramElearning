<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'class_id',
        'title',
        'meeting_date',
        'meeting_time',
        'type',
        'meeting_link',
        'description',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    // Relationship ke Mentor (User yang mengajar)
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    // Relationship ke Class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relationship ke Attendances
    public function attendances()
    {
        return $this->hasMany(Attendances::class, 'meeting_id');
    }

    // Helper methods untuk statistik attendance
    public function getAttendanceCount($status)
    {
        return $this->attendances()->where('status', $status)->count();
    }

    public function getPresentCount()
    {
        return $this->getAttendanceCount('hadir');
    }

    public function getExcusedCount()
    {
        return $this->getAttendanceCount('izin');
    }

    public function getSickCount()
    {
        return $this->getAttendanceCount('sakit');
    }

    public function getAbsentCount()
    {
        return $this->getAttendanceCount('alpa');
    }

    public function getTotalMembers()
    {
        return $this->class->members()->count();
    }
}