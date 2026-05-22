<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use App\Models\Attendances;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Auth;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $member = Auth::user();
        $classId = $member->class_id;

        if (!$classId) {
            return view('dashboard.member', [
                'attendanceCards' => [
                    ['label' => 'Hadir', 'status' => 'hadir', 'count' => 0],
                    ['label' => 'Izin', 'status' => 'izin', 'count' => 0],
                    ['label' => 'Sakit', 'status' => 'sakit', 'count' => 0],
                    ['label' => 'Alpa', 'status' => 'alpa', 'count' => 0],
                ],
                'progressSummary' => [
                    'completed_assignments' => 0,
                    'total_assignments' => 0,
                    'progress_percentage' => 0,
                    'pending_assignments' => 0,
                    'due_soon_count' => 0,
                    'overdue_count' => 0,
                ],
                'assignmentList' => collect(),
            ]);
        }

        $statusCounts = Attendances::query()
            ->where('member_id', $member->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $attendanceCards = collect([
            ['label' => 'Hadir', 'status' => 'hadir'],
            ['label' => 'Izin', 'status' => 'izin'],
            ['label' => 'Sakit', 'status' => 'sakit'],
            ['label' => 'Alpa', 'status' => 'alpa'],
        ])->map(function (array $item) use ($statusCounts) {
            $count = (int) ($statusCounts[$item['status']] ?? 0);

            return [
                'label' => $item['label'],
                'status' => $item['status'],
                'count' => $count,
            ];
        });

        $classAssignments = Assignments::query()
            ->where('class_id', $classId)
            ->select(['id', 'title', 'deadline'])
            ->orderBy('deadline')
            ->get();

        $submittedAssignmentIds = PengumpulanTugas::query()
            ->where('member_id', $member->id)
            ->whereIn('assignment_id', $classAssignments->pluck('id'))
            ->pluck('assignment_id')
            ->unique()
            ->values();

        $assignmentList = $classAssignments
            ->map(function ($assignment) use ($submittedAssignmentIds) {
                $deadline = $assignment->deadline;
                $isOverdue = $deadline->isPast();
                $diffInDays = now()->diffInDays($deadline, false);
                $isSubmitted = $submittedAssignmentIds->contains($assignment->id);

                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'deadline' => $deadline,
                    'is_submitted' => $isSubmitted,
                    'is_overdue' => $isOverdue,
                    'is_due_soon' => !$isOverdue && $diffInDays <= 3,
                    'days_left' => $diffInDays,
                ];
            })
            ->sortBy(function (array $item) {
                return [$item['is_submitted'], $item['deadline']->timestamp];
            })
            ->values();

        $pendingAssignments = $assignmentList->where('is_submitted', false);

        $dueSoonCount = $pendingAssignments->where('is_due_soon', true)->count();
        $overdueCount = $pendingAssignments->where('is_overdue', true)->count();

        $progressSummary = [
            'completed_assignments' => $submittedAssignmentIds->count(),
            'total_assignments' => $classAssignments->count(),
            'progress_percentage' => $classAssignments->count() > 0
                ? (int) round(($submittedAssignmentIds->count() / $classAssignments->count()) * 100)
                : 0,
            'pending_assignments' => $pendingAssignments->count(),
            'due_soon_count' => $dueSoonCount,
            'overdue_count' => $overdueCount,
        ];

        return view('dashboard.member', compact(
            'attendanceCards',
            'progressSummary',
            'assignmentList'
        ));
    }
}