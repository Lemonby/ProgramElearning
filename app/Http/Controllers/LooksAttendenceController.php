<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LooksAttendenceController extends Controller
{
    /**
     * Display the authenticated member's attendance history and statistics.
     */
    public function index()
    {
        $member = Auth::user();

        // Handle case where user is not in a class
        if (!$member->class_id) {
            return view('looksattendence.index', [
                'meetings' => collect(),
                'stats' => [
                    'hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpa' => 0,
                    'total' => 0,
                    'percentage' => 0,
                ],
                'warning' => 'Anda belum terdaftar di kelas mana pun. Silakan hubungi mentor atau admin.'
            ]);
        }

        // Get all meetings for this member's class via Class Eloquent Relationship, eager load attendance for this user
        $meetings = $member->class->meetings()
            ->with(['attendances' => function ($query) use ($member) {
                $query->where('member_id', $member->id);
            }])
            ->orderBy('meeting_date', 'asc')
            ->orderBy('meeting_time', 'asc')
            ->get();

        // Calculate statistics using helper method on the User model (Laravel Best Practice)
        $stats = $member->calculateAttendanceStats();

        return view('looksattendence.index', compact('meetings', 'stats'));
    }
}
