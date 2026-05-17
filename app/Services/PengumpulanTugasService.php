<?php

namespace App\Services;

use App\Events\TugasSubmitted;
use App\Models\PengumpulanTugas;
use Illuminate\Http\UploadedFile;

class PengumpulanTugasService
{
    /**
     * Simpan tugas dengan file handling dan trigger event
     * 
     * @param int $assignmentId
     * @param int $memberId
     * @param UploadedFile|null $fileTugas
     * @param string|null $linkTugas
     * @param string $judulTugas
     * @param string $namaSiswa
     * @return PengumpulanTugas
     */
    public function simpanTugas(
        int $assignmentId,
        int $memberId,
        ?UploadedFile $fileTugas = null,
        ?string $linkTugas = null,
        string $judulTugas = '',
        string $namaSiswa = ''
    ): PengumpulanTugas {
        $fileUrl = $this->handleFileUpload($assignmentId, $memberId, $fileTugas, $linkTugas);
        
        // Simpan ke database
        $submission = PengumpulanTugas::simpanTugas($assignmentId, $memberId, $fileUrl);
        
        // Trigger Event (akan di-handle oleh Listener)
        TugasSubmitted::dispatch($submission, $judulTugas, $namaSiswa);
        
        return $submission;
    }

    /**
     * Handle file upload atau ambil link
     * 
     * @param int $assignmentId
     * @param int $memberId
     * @param UploadedFile|null $fileTugas
     * @param string|null $linkTugas
     * @return string
     */
    private function handleFileUpload(
        int $assignmentId,
        int $memberId,
        ?UploadedFile $fileTugas = null,
        ?string $linkTugas = null
    ): string {
        // Prioritas: File > Link
        if ($fileTugas) {
            return $this->uploadFile($assignmentId, $memberId, $fileTugas);
        }

        if ($linkTugas) {
            return $linkTugas;
        }

        throw new \Exception('File atau link tugas harus diisi.');
    }

    /**
     * Upload file ke storage
     * 
     * @param int $assignmentId
     * @param int $memberId
     * @param UploadedFile $fileTugas
     * @return string Path file di storage
     */
    private function uploadFile(int $assignmentId, int $memberId, UploadedFile $fileTugas): string
    {
        $fileName = "assignment_{$assignmentId}_member_{$memberId}_" . time() . "." . $fileTugas->getClientOriginalExtension();
        
        return $fileTugas->storeAs('submissions', $fileName, 'local');
    }
}
