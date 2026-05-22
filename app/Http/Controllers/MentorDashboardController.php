<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Assignments;
use App\Models\PengumpulanTugas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class MentorDashboardController extends Controller
{
    /**
     * Gather stats and build interactive feed for the mentor dashboard.
     */
    public function index()
    {
        $mentor = Auth::user();
        $classId = $mentor->class_id;

        // 1. Total Classes
        $totalClasses = ClassModel::count();

        // 2. Total Members in the Mentor's Class
        $totalMembers = 0;
        if ($classId) {
            $totalMembers = User::where('class_id', $classId)
                ->whereIn('role', ['member', 'student'])
                ->count();
        }

        // 3. Ungraded Submissions ("Belum dinilai")
        $pendingGrading = 0;
        if ($classId) {
            $pendingGrading = PengumpulanTugas::whereHas('assignment', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })->whereNull('graded_at')->count();
        }

        // 4. Graded Submissions ("Sudah dinilai")
        $gradedCount = 0;
        if ($classId) {
            $gradedCount = PengumpulanTugas::whereHas('assignment', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })->whereNotNull('graded_at')->count();
        }

        // 5. Recent Activities Timeline
        $recentSubmissions = collect();
        if ($classId) {
            $recentSubmissions = PengumpulanTugas::with(['member', 'assignment'])
                ->whereHas('assignment', function ($query) use ($classId) {
                    $query->where('class_id', $classId);
                })
                ->orderBy('submitted_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($submission) {
                    return [
                        'type' => 'submission',
                        'date' => $submission->submitted_at,
                        'title' => 'TUGAS DISELESAIKAN!',
                        'description' => ($submission->member->name ?? 'Student') . ' baru saja menyelesaikan tugas! Yuk beri nilai.',
                        'detail_url' => route('assignment.show', $submission->assignment_id),
                    ];
                });
        }

        // Merge, sort chronologically desc, and cap at 5 activities
        $activities = $recentSubmissions
            ->sortByDesc(function ($activity) {
                return $activity['date'] instanceof Carbon ? $activity['date']->timestamp : Carbon::parse($activity['date'])->timestamp;
            })
            ->take(5)
            ->values();

        return view('dashboard.mentor', compact(
            'totalClasses',
            'totalMembers',
            'pendingGrading',
            'gradedCount',
            'activities'
        ));
    }
}
