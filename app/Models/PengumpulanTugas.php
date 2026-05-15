<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    // Konfigurasi model
    protected $table = 'submissions'; // nama tabel di database
    protected $fillable = ['assignment_id', 'member_id', 'file_url']; // field yang bisa di-fill
    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    // Relasi ke Assignment
    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
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
            // submitted_at otomatis terisi dari migration (useCurrent())
        ]);
    }
}
