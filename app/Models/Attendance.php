<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\User;

class Attendance extends Model
{
     protected $fillable = [
        'meeting_id',
        'member_id',
        'status',
        'input_by',
    ];
    

    public function meeting()
{
    return $this->belongsTo(Meeting::class);
}


public function member()
{
    return $this->belongsTo(User::class, 'member_id');
}
}

