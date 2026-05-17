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
        $meetings = Meeting::latest()->get();
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
            'title' =>'required',
            'meeting_date' => 'required',
            'meeting_time' => 'required',
            'meeting_link' => 'required|url',
        ]);

        Meeting::create([
            'mentor_id' => 1,
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
        return view('meeting.edit', compact('meeting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'title' =>'required',
            'meeting_date' => 'required',
            'meeting_time' => 'required',
            'meeting_link' => 'required|url',
        ]);

        $meeting->update([
            'title' =>$request->title,
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
      $meeting->delete(); 

      return redirect()->route('meeting.index')
        ->with('success', 'Meeting berhasil dihapus');
    }
}
