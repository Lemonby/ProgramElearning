<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'title',
        'meeting_date',
        'meeting_time',
        'meeting_link',
        'description',
    ];
}