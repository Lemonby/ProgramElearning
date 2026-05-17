<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
   protected $fillable = [
    'mentor_id',
    'title',
    'meeting_date',
    'meeting_time',
    'meeting_link',
    'description',
];

    public function mentor(){
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
