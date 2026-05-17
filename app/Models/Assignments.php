<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
    protected $table = 'assignments';
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'deadline',
        'file_path'
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the class that owns this assignment.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Relasi ke submissions (PengumpulanTugas)
     */
    public function submissions()
    {
        return $this->hasMany('App\Models\PengumpulanTugas', 'assignment_id');
    }
}