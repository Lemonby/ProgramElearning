<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $table = 'attendances';
    protected $fillable = [
        'meeting_id',
        'member_id',
        'status',
        'input_by',
    ];

    // Relationship ke Meeting
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }

    // Relationship ke Member (User sebagai member)
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // Relationship ke User yang mencatat absensi (mentor/input_by)
    public function inputBy()
    {
        return $this->belongsTo(User::class, 'input_by');
    }
}
