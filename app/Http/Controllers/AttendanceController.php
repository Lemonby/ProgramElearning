<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function myAttendance()
{
    $attendances = Attendance::where('member_id', 1)->get();

    return view('attendances.my-attendance',
        compact('attendances'));
}

    public function index()
    {
        $attendances = Attendance::all();

        return view('attendances.index',
            compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meetings = Meeting::all();
        $users = User::all();

        return view('attendances.create',
            compact('meetings', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'meeting_id' => 'required',
            'member_id' => 'required',
            'status' => 'required',
        ]);

        Attendance::create([
            'meeting_id' => $request->meeting_id,
            'member_id' => $request->member_id,
            'status' => $request->status,
            'input_by' => 1,
        ]);

        return redirect()->route('attendances.index')
            ->with('success', 'Absensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        $meetings = Meeting::all();
        $users = User::all();

        return view('attendances.edit',
            compact('attendance', 'meetings', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $attendance->update([
            'meeting_id' => $request->meeting_id,
            'member_id' => $request->member_id,
            'status' => $request->status,
        ]);

        return redirect()->route('attendances.index')
            ->with('success', 'Absensi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendances.index')
            ->with('success', 'Absensi berhasil dihapus');
    }
}