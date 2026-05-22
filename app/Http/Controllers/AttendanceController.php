<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show meetings dari mentor yang sedang login
        $authUser = Auth::user();
        
        $meetings = Meeting::query()->where('mentor_id', $authUser->id)
            ->with(['class', 'attendances.member'])
            ->latest('created_at')
            ->get();

        return view('attendances.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource (batch attendance)
     */
    public function create()
    {
        $authUser = Auth::user();
        
        // Get meetings dari mentor yang sedang login yang belum selesai
        $meetings = Meeting::query()->where('mentor_id', $authUser->id)
            ->with('class')
            ->latest('created_at')
            ->get();

        return view('attendances.create', compact('meetings'));
    }

    /**
     * Get members for selected meeting (AJAX endpoint)
     */
    public function getMeetingMembers($meetingId)
    {
        $authUser = Auth::user();
        $meeting = Meeting::findOrFail($meetingId);

        // Authorization check - hanya mentor dari meeting ini yang bisa akses
        if ($meeting->mentor_id !== $authUser->id) {
            return response()->json(['error' => 'Anda tidak memiliki akses ke meeting ini'], 403);
        }

        // Get members dari kelas yang merupakan student/member (role = 'member')
        $members = $meeting->class->members()
            ->whereIn('role', ['member', 'student'])
            ->orderBy('name')
            ->get();
        
        // Get existing attendances for this meeting
        $existingAttendances = Attendances::query()->where('meeting_id', $meetingId)
            ->pluck('status', 'member_id');

        return response()->json([
            'members' => $members,
            'existingAttendances' => $existingAttendances
        ]);
    }

    /**
     * Store batch attendance
     */
    public function store(Request $request)
    {
        $authUser = Auth::user();
        
        $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'attendances' => 'required|array|min:1',
            'attendances.*.member_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ], [
            'meeting_id.required' => 'Silakan pilih pertemuan terlebih dahulu',
            'attendances.required' => 'Minimal satu member harus diabsensi',
            'attendances.min' => 'Minimal satu member harus diabsensi',
            'attendances.*.member_id.required' => 'Member ID diperlukan',
            'attendances.*.status.required' => 'Status kehadiran diperlukan',
            'attendances.*.status.in' => 'Status kehadiran tidak valid',
        ]);

        try {
            $meeting = Meeting::findOrFail($request->meeting_id);
            
            // Authorization check - hanya mentor meeting ini yang bisa manage attendance
            if ($meeting->mentor_id !== $authUser->id) {
                return back()->with('error', 'Anda tidak memiliki akses untuk mengubah absensi meeting ini');
            }

            // Validate all members belong to meeting's class
            $classMembers = $meeting->class->members()
                ->whereIn('role', ['member', 'student'])
                ->pluck('id')
                ->toArray();

            foreach ($request->attendances as $attendance) {
                if (!in_array($attendance['member_id'], $classMembers)) {
                    return back()->with('error', 'Salah satu member bukan bagian dari kelas ini');
                }
            }
            
            foreach ($request->attendances as $attendance) {
                // Delete existing attendance jika ada (untuk replace)
                Attendances::query()->where('meeting_id', $meeting->id)
                    ->where('member_id', $attendance['member_id'])
                    ->delete();

                // Insert new attendance
                Attendances::create([
                    'meeting_id' => $meeting->id,
                    'member_id' => $attendance['member_id'],
                    'status' => $attendance['status'],
                    'input_by' => $authUser->id,
                ]);
            }

            return redirect()->route('attendances.index')
                ->with('success', 'Absensi berhasil disimpan untuk ' . count($request->attendances) . ' member');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan absensi: ' . $e->getMessage());
        }
    }

    /**
     * Display attendance for a specific meeting
     */
    public function show(string $id)
    {
        $authUser = Auth::user();
        $meeting = Meeting::with(['class', 'attendances.member', 'attendances.inputBy'])->findOrFail($id);
        
        // Authorization check
        if ($meeting->mentor_id !== $authUser->id) {
            abort(403, 'Anda tidak memiliki akses ke data absensi ini');
        }
        
        return view('attendances.show', compact('meeting'));
    }

    /**
     * Show the form for editing attendance of a meeting
     */
    public function edit($meetingId)
    {
        $authUser = Auth::user();
        $meeting = Meeting::with(['class.members', 'attendances'])->findOrFail($meetingId);

        // Authorization check
        if ($meeting->mentor_id !== $authUser->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit absensi ini');
        }

        // Get members yang merupakan student/member, ordered by name
        $members = $meeting->class->members()
            ->whereIn('role', ['member', 'student'])
            ->orderBy('name')
            ->get();
        
        $existingAttendances = $meeting->attendances->pluck('status', 'member_id');

        return view('attendances.edit', compact('meeting', 'members', 'existingAttendances'));
    }

    /**
     * Update attendance for a meeting
     */
    public function update(Request $request, $meetingId)
    {
        $authUser = Auth::user();
        $meeting = Meeting::findOrFail($meetingId);

        // Authorization check
        if ($meeting->mentor_id !== $authUser->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengubah absensi ini');
        }

        $request->validate([
            'attendances' => 'required|array|min:1',
            'attendances.*.member_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ], [
            'attendances.min' => 'Minimal satu member harus diabsensi',
            'attendances.*.member_id.required' => 'Member ID diperlukan',
            'attendances.*.status.required' => 'Status kehadiran diperlukan',
        ]);

        try {
            // Validate all members belong to meeting's class
            $classMembers = $meeting->class->members()
                ->whereIn('role', ['member', 'student'])
                ->pluck('id')
                ->toArray();

            foreach ($request->attendances as $attendance) {
                if (!in_array($attendance['member_id'], $classMembers)) {
                    return back()->with('error', 'Salah satu member bukan bagian dari kelas ini');
                }
            }

            // Delete old attendances
            Attendances::query()->where('meeting_id', $meeting->id)->delete();

            // Create new attendances
            foreach ($request->attendances as $attendance) {
                Attendances::create([
                    'meeting_id' => $meeting->id,
                    'member_id' => $attendance['member_id'],
                    'status' => $attendance['status'],
                    'input_by' => $authUser->id,
                ]);
            }

            return redirect()->route('attendances.index')
                ->with('success', 'Absensi berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy($meetingId)
    {
        $authUser = Auth::user();
        $meeting = Meeting::findOrFail($meetingId);

        // Authorization check
        if ($meeting->mentor_id !== $authUser->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus data absensi ini');
        }

        Attendances::query()->where('meeting_id', $meeting->id)->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Data absensi untuk meeting ini berhasil dihapus');
    }

    /**
     * View member's own attendance
     */
    public function myAttendance()
    {
        $member = Auth::user();

        $attendances = Attendances::query()
            ->where('member_id', $member->id)
            ->whereHas('meeting', function ($query) use ($member) {
                $query->where('class_id', $member->class_id);
            })
            ->with(['meeting.class', 'inputBy'])
            ->latest('created_at')
            ->get();

        $summaryCards = collect([
            ['label' => 'Hadir', 'status' => 'hadir', 'color' => 'emerald'],
            ['label' => 'Sakit', 'status' => 'sakit', 'color' => 'rose'],
            ['label' => 'Alpha', 'status' => 'alpa', 'color' => 'amber'],
        ])->map(function (array $card) use ($attendances) {
            return [
                'label' => $card['label'],
                'status' => $card['status'],
                'count' => $attendances->where('status', $card['status'])->count(),
                'color' => $card['color'],
            ];
        });

        return view('attendances.my-attendance', compact('attendances', 'summaryCards'));
    }
}