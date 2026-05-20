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
        $userId = Auth::id();
        
        // Get all assignments with submission status
        $assignments = Assignments::with(['class', 'submissions' => function ($query) use ($userId) {
            $query->where('member_id', $userId);
        }])
        ->get()
        ->map(function ($assignment) use ($userId) {
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
        $assignment = Assignments::findOrFail($assignmentId);
        $userId = Auth::id();

        // Check if already submitted
        $existingSubmission = PengumpulanTugas::where('assignment_id', $assignmentId)
            ->where('member_id', $userId)
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
            $submission = $this->submissionService->createSubmission(
                assignmentId: $request->validated('assignment_id'),
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
        
        // Check authorization
        if ($submission->member_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat submission ini.');
        }

        $submission->load('assignment', 'member');

        return view('submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified submission
     */
    public function edit($submissionId)
    {
        $submission = PengumpulanTugas::findOrFail($submissionId);

        // Check authorization
        if ($submission->member_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk edit submission ini.');
        }

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

            // Check authorization
            if ($submission->member_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk update submission ini.');
            }

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

            // Check authorization
            if ($submission->member_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk delete submission ini.');
            }

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

            // Check authorization
            if ($submission->member_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses untuk download file ini.');
            }

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
}
