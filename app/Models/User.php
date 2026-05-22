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

    // Relationship ke submissions/PengumpulanTugas (untuk members)
    public function submissions()
    {
        return $this->hasMany(PengumpulanTugas::class, 'member_id');
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

    // Fetch attendance grouped by status
    public function getAttendanceStatusCounts()
    {
        return $this->attendances()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
    }

    // Calculate attendance statistics
    public function calculateAttendanceStats()
    {
        if (!$this->class_id) {
            return [
                'hadir' => 0,
                'izin' => 0,
                'sakit' => 0,
                'alpa' => 0,
                'total' => 0,
                'percentage' => 0,
            ];
        }

        $statusCounts = $this->getAttendanceStatusCounts();
        $hadir = (int) ($statusCounts['hadir'] ?? 0);
        $izin = (int) ($statusCounts['izin'] ?? 0);
        $sakit = (int) ($statusCounts['sakit'] ?? 0);
        $alpa = (int) ($statusCounts['alpa'] ?? 0);

        $total = $hadir + $izin + $sakit + $alpa;
        $percentage = $total > 0 ? round(($hadir / $total) * 100) : 0;

        return [
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpa' => $alpa,
            'total' => $total,
            'percentage' => $percentage,
        ];
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