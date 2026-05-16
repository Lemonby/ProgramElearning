<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    //
    protected $table = 'meetings';
    protected $fillable = [
        'class_id',
        'title',
        'meeting_time',
        'meeting_link'
    ];
}
