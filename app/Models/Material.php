<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'file_url',
    ];

    /**
     * Get the class that owns the material.
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}