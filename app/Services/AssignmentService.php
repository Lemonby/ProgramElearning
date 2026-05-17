<?php

namespace App\Services;

use App\Models\Assignments;
use Illuminate\Http\UploadedFile;

class AssignmentService
{
    /**
     * Simpan assignment dengan file handling
     * 
     * @param string $title
     * @param string $description
     * @param string $deadline
     * @param int $classId
     * @param UploadedFile|null $fileAssignment
     * @param string|null $linkAssignment
     * @return Assignments
     */
    public function simpanAssignment(
        string $title,
        string $description,
        string $deadline,
        int $classId,
        ?UploadedFile $fileAssignment = null,
        ?string $linkAssignment = null
    ): Assignments {
        $fileUrl = $this->handleFileUpload($fileAssignment, $linkAssignment);
        
        // Simpan ke database
        $assignment = Assignments::create([
            'title' => $title,
            'description' => $description,
            'deadline' => $deadline,
            'class_id' => $classId,
            'file_path' => $fileUrl, // Simpan path file atau link
        ]);
        
        return $assignment;
    }

    /**
     * Handle file upload atau ambil link
     * 
     * @param UploadedFile|null $fileAssignment
     * @param string|null $linkAssignment
     * @return string
     */
    private function handleFileUpload(
        ?UploadedFile $fileAssignment = null,
        ?string $linkAssignment = null
    ): string {
        // Prioritas: File > Link
        if ($fileAssignment) {
            return $this->uploadFile($fileAssignment);
        }

        if ($linkAssignment) {
            return $linkAssignment;
        }

        throw new \Exception('File atau link assignment harus diisi.');
    }

    /**
     * Upload file ke storage
     * 
     * @param UploadedFile $fileAssignment
     * @return string Path file di storage (accessible via public/storage)
     */
    private function uploadFile(UploadedFile $fileAssignment): string
    {
        $fileName = "assignment_" . time() . "." . $fileAssignment->getClientOriginalExtension();
        
        // Simpan ke storage/app/assignments (bisa di-download via /storage/assignments/...)
        // menggunakan 'public' disk agar accessible via browser
        return $fileAssignment->storeAs('assignments', $fileName, 'public');
    }

    /**
     * Update assignment
     * 
     * @param Assignments $assignment
     * @param string $title
     * @param string $description
     * @param string $deadline
     * @param int $classId
     * @param UploadedFile|null $fileAssignment
     * @param string|null $linkAssignment
     * @return Assignments
     */
    public function updateAssignment(
        Assignments $assignment,
        string $title,
        string $description,
        string $deadline,
        int $classId,
        ?UploadedFile $fileAssignment = null,
        ?string $linkAssignment = null
    ): Assignments {
        // Handle file jika ada file baru
        if ($fileAssignment || $linkAssignment) {
            $fileUrl = $this->handleFileUpload($fileAssignment, $linkAssignment);
            $assignment->update(['file_path' => $fileUrl]);
        }

        // Update data lainnya
        $assignment->update([
            'title' => $title,
            'description' => $description,
            'deadline' => $deadline,
            'class_id' => $classId,
        ]);

        return $assignment;
    }

    /**
     * Delete assignment
     * 
     * @param Assignments $assignment
     * @return bool
     */
    public function deleteAssignment(Assignments $assignment): bool
    {
        return $assignment->delete();
    }
}
