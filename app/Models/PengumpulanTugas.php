<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    // Disable timestamps karena tabel submissions tidak punya updated_at & created_at
    public $timestamps = false;

    // Nama tabel di database
    protected $table = 'submissions';

    // Konfigurasi model
    protected $fillable = [
        'assignment_id', 
        'member_id', 
        'file_url', 
        'is_upload',
        'submitted_at',
        'graded_at'
    ];
    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ]; // casting untuk tanggal

    // Relasi ke Assignment
    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignments');
    }

    // Relasi ke User (member/siswa)
    public function member()
    {
        return $this->belongsTo('App\Models\User', 'member_id');
    }

    /**
     * Method untuk menyimpan tugas ke database
     * 
     * @param int $assignmentId
     * @param int $memberId
     * @param string $fileUrl (path file atau URL link)
     * @return PengumpulanTugas
     */
    public static function simpanTugas($assignmentId, $memberId, $fileUrl)
    {
        return self::create([
            'assignment_id' => $assignmentId,
            'member_id' => $memberId,
            'file_url' => $fileUrl,
            'is_upload' => 'sudah',
            'submitted_at' => now() // otomatis terisi dari migration (useCurrent())
        ]);
    }
}
