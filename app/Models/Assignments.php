<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    //
    protected $table = 'assignments';
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'deadline'
    ];
    
    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relasi ke submissions
     */
    public function submissions()
    {
        return $this->hasMany('App\Models\PengumpulanTugas', 'assignment_id');
    }
}
