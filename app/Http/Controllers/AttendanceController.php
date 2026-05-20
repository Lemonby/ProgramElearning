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
        // Show all meetings dengan attendance data
        $meetings = Meeting::with(['class', 'attendances.member'])
            ->latest('created_at')
            ->get();

        return view('attendances.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource (batch attendance)
     */
    public function create()
    {
        // Get meetings yang belum selesai (belum lewat meeting date jika ada)
        $meetings = Meeting::with('class')
            ->latest('created_at')
            ->get();

        return view('attendances.create', compact('meetings'));
    }

    /**
     * Get members for selected meeting (AJAX endpoint)
     */
    public function getMeetingMembers($meetingId)
    {
        $meeting = Meeting::with('class.members')->findOrFail($meetingId);

        $members = $meeting->class->members()->get();
        
        // Get existing attendances for this meeting
        $existingAttendances = Attendances::where('meeting_id', $meetingId)
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
        $userId = Auth::id();

        $request->validate([
            'meeting_id' => 'required|exists:meetings,id',
            'attendances' => 'required|array',
            'attendances.*.member_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ], [
            'attendances.required' => 'Minimal satu member harus diabsensi',
            'attendances.*.member_id.required' => 'Member ID diperlukan',
            'attendances.*.status.required' => 'Status kehadiran diperlukan',
        ]);

        try {
            $meeting = Meeting::findOrFail($request->meeting_id);
            
            foreach ($request->attendances as $attendance) {
                // Delete existing attendance jika ada (update)
                Attendances::where('meeting_id', $meeting->id)
                    ->where('member_id', $attendance['member_id'])
                    ->delete();

                // Insert new attendance
                Attendances::create([
                    'meeting_id' => $meeting->id,
                    'member_id' => $attendance['member_id'],
                    'status' => $attendance['status'],
                    'input_by' => $userId,
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
        $meeting = Meeting::with(['class', 'attendances.member'])->findOrFail($id);
        return view('attendances.show', compact('meeting'));
    }

    /**
     * Show the form for editing attendance of a meeting
     */
    public function edit($meetingId)
    {
        $meeting = Meeting::with(['class.members', 'attendances'])->findOrFail($meetingId);

        $members = $meeting->class->members;
        $existingAttendances = $meeting->attendances->pluck('status', 'member_id');

        return view('attendances.edit', compact('meeting', 'members', 'existingAttendances'));
    }

    /**
     * Update attendance for a meeting
     */
    public function update(Request $request, $meetingId)
    {
        $userId = Auth::id();
        $meeting = Meeting::findOrFail($meetingId);

        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.member_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,sakit,alpa',
        ]);

        try {
            // Delete old attendances
            Attendances::where('meeting_id', $meeting->id)->delete();

            // Create new attendances
            foreach ($request->attendances as $attendance) {
                Attendances::create([
                    'meeting_id' => $meeting->id,
                    'member_id' => $attendance['member_id'],
                    'status' => $attendance['status'],
                    'input_by' => $userId,
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
        $meeting = Meeting::findOrFail($meetingId);
        Attendances::where('meeting_id', $meeting->id)->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Data absensi untuk meeting ini berhasil dihapus');
    }

    /**
     * View member's own attendance
     */
    public function myAttendance()
    {
        $memberId = Auth::id();
        $attendances = Attendances::where('member_id', $memberId)
            ->with(['meeting.class', 'inputBy'])
            ->latest('created_at')
            ->get();

        return view('attendances.my-attendance', compact('attendances'));
    }
}