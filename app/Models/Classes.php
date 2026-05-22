<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    protected $table = 'classes';
    protected $fillable = [
        'name',
        'description' 
    ];

    // Relationship ke members (students di kelas)
    public function members()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    // Relationship ke meetings di kelas
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'class_id');
    }

    // Relationship ke assignments di kelas
    public function assignments()
    {
        return $this->hasMany(Assignments::class, 'class_id');
    }

    // Relationship ke materials di kelas
    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }
}
