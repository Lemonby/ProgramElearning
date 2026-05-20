<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';

    public function members()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'class_id');
    }
}