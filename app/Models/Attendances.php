<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    //
    protected $table = 'attendances';
    protected $fillable = [
        'meeting_id',
        'member_id',
        'status',
        'input_by',
    ];
}
