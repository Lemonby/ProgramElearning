<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classId = auth()->user()->class_id;
        $meetings = Meeting::where('class_id', $classId)->latest()->get();
        return view('meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meetings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'meeting_date' => 'required',
            'meeting_time' => 'required',
            'meeting_type' => 'required|in:online,offline',
            'meeting_link' => 'nullable|url|required_unless:meeting_type,offline',
        ]);

        Meeting::create([
            'mentor_id' => auth()->id(),
            'class_id' => auth()->user()->class_id,
            'title' => $request->title,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
            'description' => $request->description,
        ]);

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meeting $meeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        // Check if user is authorized to edit this meeting
        if ($meeting->class_id != auth()->user()->class_id) {
            return abort(403, 'Unauthorized');
        }
        return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meeting $meeting)
    {
        // Check if user is authorized to update this meeting
        if ($meeting->class_id != auth()->user()->class_id) {
            return abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required',
            'meeting_date' => 'required',
            'meeting_time' => 'required',
            'meeting_link' => 'required',
        ]);

        $meeting->update([
            'title' => $request->title,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'meeting_link' => $request->meeting_link,
            'description' => $request->description,
        ]);

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meeting $meeting)
    {
        // Check if user is authorized to delete this meeting
        if ($meeting->class_id != auth()->user()->class_id) {
            return abort(403, 'Unauthorized');
        }

        $meeting->delete(); 

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting berhasil dihapus');
    }
}
