<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    // Tambahkan baris ini untuk memberi tahu Laravel kalau tabel ini TIDAK punya updated_at & created_at
    public $timestamps = false; 

    protected $fillable = [
        'assignment_id', 
        'member_id', 
        'file_url', 
        'submitted_at', 
        'graded_at'
    ];
}