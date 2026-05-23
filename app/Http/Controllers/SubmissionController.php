<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\Assignments;
use App\Models\PengumpulanTugas;
use App\Services\SubmissionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    private SubmissionService $submissionService;

    public function __construct(SubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    /**
     * Display a listing of assignments (untuk member collect)
     */
    public function index()
    {
        $user = Auth::user();
        $classId = $this->getMemberClassId();

        abort_unless($classId, 403, 'Kelas member belum diset.');

        $assignments = $user->class->assignments()
            ->with(['class', 'submissions' => function ($query) use ($user) {
                $query->where('member_id', $user->id);
            }])
            ->latest()
            ->get()
            ->map(function ($assignment) {
                $assignment->isSubmitted = $assignment->submissions->isNotEmpty();
                $assignment->submission = $assignment->submissions->first();

                return $assignment;
            });

        return view('submissions.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new submission
     */
    public function create($assignmentId)
    {
        $assignment = $this->getAssignmentForMemberClassOrFail($assignmentId);
        $user = Auth::user();

        // Check if already submitted via User Eloquent relationship
        $existingSubmission = $user->submissions()
            ->where('assignment_id', $assignment->id)
            ->first();

        if ($existingSubmission) {
            return redirect()->route('submissions.index')
                ->with('info', 'Anda sudah mengumpulkan tugas ini. Silakan edit jika ingin mengubah.');
        }

        return view('submissions.create', compact('assignment'));
    }

    /**
     * Store a newly created submission
     */
    public function store(StoreSubmissionRequest $request)
    {
        try {
            $assignment = $this->getAssignmentForMemberClassOrFail((int) $request->validated('assignment_id'));

            $submission = $this->submissionService->createSubmission(
                assignmentId: $assignment->id,
                memberId: Auth::id(),
                fileTugas: $request->file('file_submission'),
                linkTugas: $request->validated('link_submission'),
            );

            return redirect()->route('submissions.show', $submission->id)
                ->with('success', 'Tugas berhasil dikumpulkan! Terima kasih.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan tugas: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified submission
     */
    public function show($submissionId)
    {
        $submission = PengumpulanTugas::findOrFail($submissionId);
        
        $this->ensureSubmissionBelongsToMemberClass($submission);
        $this->ensureSubmissionOwnedByMember($submission);

        $submission->load('assignment', 'member');

        return view('submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified submission
     */
    public function edit($submissionId)
    {
        $submission = PengumpulanTugas::findOrFail($submissionId);

        $this->ensureSubmissionBelongsToMemberClass($submission);
        $this->ensureSubmissionOwnedByMember($submission);

        // Check if assignment deadline has passed
        if ($submission->assignment->deadline < now()) {
            return redirect()->route('submissions.show', $submission->id)
                ->with('error', 'Tidak dapat mengedit submission, deadline sudah lewat.');
        }

        $assignment = $submission->assignment;

        return view('submissions.edit', compact('submission', 'assignment'));
    }

    /**
     * Update the specified submission
     */
    public function update(UpdateSubmissionRequest $request, $submissionId)
    {
        try {
            $submission = PengumpulanTugas::findOrFail($submissionId);

            $this->ensureSubmissionBelongsToMemberClass($submission);
            $this->ensureSubmissionOwnedByMember($submission);

            // Check if deadline has passed
            if ($submission->assignment->deadline < now()) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat mengupdate submission, deadline sudah lewat.');
            }

            $submission = $this->submissionService->updateSubmission(
                submission: $submission,
                fileTugas: $request->file('file_submission'),
                linkTugas: $request->validated('link_submission'),
            );

            return redirect()->route('submissions.show', $submission->id)
                ->with('success', 'Tugas berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tugas: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified submission
     */
    public function destroy($submissionId)
    {
        try {
            $submission = PengumpulanTugas::findOrFail($submissionId);

            $this->ensureSubmissionBelongsToMemberClass($submission);
            $this->ensureSubmissionOwnedByMember($submission);

            // Check if deadline has passed
            if ($submission->assignment->deadline < now()) {
                return redirect()->back()
                    ->with('error', 'Tidak dapat menghapus submission, deadline sudah lewat.');
            }

            $this->submissionService->deleteSubmission($submission);

            return redirect()->route('submissions.index')
                ->with('success', 'Submission berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus submission: ' . $e->getMessage());
        }
    }

    /**
     * Download the submission file
     */
    public function download($submissionId)
    {
        try {
            $submission = PengumpulanTugas::findOrFail($submissionId);

            $this->ensureSubmissionBelongsToMemberClass($submission);
            $this->ensureSubmissionOwnedByMember($submission);

            // Check if it's an uploaded file
            if (!$submission->is_upload) {
                abort(400, 'File ini adalah link eksternal, bukan file upload.');
            }

            // Check if file exists
            if (!Storage::exists($submission->file_url)) {
                abort(404, 'File tidak ditemukan.');
            }

            return Storage::download($submission->file_url);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mendownload file: ' . $e->getMessage());
        }
    }

    private function getMemberClassId(): ?int
    {
        $user = Auth::user();

        return $user?->class_id ? (int) $user->class_id : null;
    }

    private function getAssignmentForMemberClassOrFail(int $assignmentId): Assignments
    {
        $user = Auth::user();
        abort_unless($user->class_id, 403, 'Kelas member belum diset.');

        return $user->class->assignments()
            ->whereKey($assignmentId)
            ->firstOrFail();
    }

    private function ensureSubmissionBelongsToMemberClass(PengumpulanTugas $submission): void
    {
        $classId = $this->getMemberClassId();

        abort_unless($classId, 403, 'Kelas member belum diset.');
        abort_unless((int) $submission->assignment->class_id === $classId, 403, 'Submission ini bukan milik kelas Anda.');
    }

    private function ensureSubmissionOwnedByMember(PengumpulanTugas $submission): void
    {
        abort_unless((int) $submission->member_id === (int) Auth::id(), 403, 'Anda tidak memiliki akses untuk data submission ini.');
    }
}
