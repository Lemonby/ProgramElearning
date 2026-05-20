<?php

namespace App\Services;

use App\Models\PengumpulanTugas;
use App\Models\Submission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SubmissionService
{
    /**
     * Create a new submission
     */
    public function createSubmission(
        int $assignmentId,
        int $memberId,
        ?UploadedFile $fileTugas = null,
        ?string $linkTugas = null
    ): PengumpulanTugas {
        $fileUrl = $this->handleFileUpload($assignmentId, $memberId, $fileTugas, $linkTugas);

        $submission = PengumpulanTugas::create([
            'assignment_id' => $assignmentId,
            'member_id' => $memberId,
            'file_url' => $fileUrl,
            'submitted_at' => now(),
            'is_upload' => $fileTugas ? 1 : 0,
        ]);

        return $submission;
    }

    /**
     * Update an existing submission
     */
    public function updateSubmission(
        PengumpulanTugas $submission,
        ?UploadedFile $fileTugas = null,
        ?string $linkTugas = null
    ): PengumpulanTugas {
        // If new file is uploaded, delete the old one
        if ($fileTugas) {
            if ($submission->is_upload && Storage::exists($submission->file_url)) {
                Storage::delete($submission->file_url);
            }
            $fileUrl = $this->uploadFile($submission->assignment_id, $submission->member_id, $fileTugas);
            $isUpload = 1;
        } elseif ($linkTugas) {
            // If new link is provided, use it
            $fileUrl = $linkTugas;
            $isUpload = 0;
        } else {
            // Keep the existing one
            $fileUrl = $submission->file_url;
            $isUpload = $submission->is_upload;
        }

        $submission->update([
            'file_url' => $fileUrl,
            'submitted_at' => now(),
            'is_upload' => $isUpload,
        ]);

        return $submission;
    }

    /**
     * Delete a submission and its file
     */
    public function deleteSubmission(PengumpulanTugas $submission): void
    {
        // Delete file if exists
        if ($submission->is_upload && Storage::exists($submission->file_url)) {
            Storage::delete($submission->file_url);
        }

        $submission->delete();
    }

    /**
     * Handle file upload or link
     */
    private function handleFileUpload(
        int $assignmentId,
        int $memberId,
        ?UploadedFile $fileTugas = null,
        ?string $linkTugas = null
    ): string {
        // Priority: File > Link
        if ($fileTugas) {
            return $this->uploadFile($assignmentId, $memberId, $fileTugas);
        }

        if ($linkTugas) {
            return $linkTugas;
        }

        throw new \Exception('File atau link tugas harus diisi.');
    }

    /**
     * Upload file to storage
     */
    private function uploadFile(int $assignmentId, int $memberId, UploadedFile $fileTugas): string
    {
        $fileName = "assignment_{$assignmentId}_member_{$memberId}_" . time() . "." . $fileTugas->getClientOriginalExtension();

        return $fileTugas->storeAs('submissions', $fileName, 'local');
    }
}
