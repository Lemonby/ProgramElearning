<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignments;
use App\Models\Classes;
use App\Services\AssignmentService;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private AssignmentService $assignmentService;

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Show daftar assignment untuk mentor
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $assignments = Assignments::with('class')->latest()->get();
        
        return view('assignment.index', compact('assignments'));
    }

    /**
     * Show form create assignment
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $classes = Classes::all();
        
        return view('assignment.create', compact('classes'));
    }

    /**
     * Simpan assignment ke database
     * 
     * @param StoreAssignmentRequest $request (validasi otomatis)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAssignmentRequest $request)
    {
        try {
            // Service handle semua logic: file upload + simpan db
            $assignment = $this->assignmentService->simpanAssignment(
                title: $request->input('title'),
                description: $request->input('description'),
                deadline: $request->input('deadline'),
                classId: $request->input('class_id'),
                fileAssignment: $request->file('file_assignment'),
                linkAssignment: $request->input('link_assignment'),
            );

            return redirect()->route('assignment.index')
                ->with('success', 'Assignment berhasil dibuat! ID: ' . $assignment->id);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan assignment: ' . $e->getMessage());
        }
    }

    /**
     * Show detail assignment
     * 
     * @param Assignments $assignment
     * @return \Illuminate\View\View
     */
    public function show(Assignments $assignment)
    {
        $assignment->load('class');
        
        return view('assignment.show', compact('assignment'));
    }

    /**
     * Show form edit assignment
     * 
     * @param Assignments $assignment
     * @return \Illuminate\View\View
     */
    public function edit(Assignments $assignment)
    {
        $classes = Classes::all();
        $assignment->load('class');
        
        return view('assignment.edit', compact('assignment', 'classes'));
    }

    /**
     * Update assignment
     * 
     * @param Request $request
     * @param Assignments $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Assignments $assignment)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:5000',
                'deadline' => 'required|date|after_or_equal:today',
                'class_id' => 'required|integer|exists:classes,id',
                'file_assignment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240',
                'link_assignment' => 'nullable|url',
            ]);

            $assignment = $this->assignmentService->updateAssignment(
                assignment: $assignment,
                title: $validated['title'],
                description: $validated['description'],
                deadline: $validated['deadline'],
                classId: $validated['class_id'],
                fileAssignment: $request->file('file_assignment'),
                linkAssignment: $validated['link_assignment'] ?? null,
            );

            return redirect()->route('assignment.show', $assignment->id)
                ->with('success', 'Assignment berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui assignment: ' . $e->getMessage());
        }
    }

    /**
     * Delete assignment
     * 
     * @param Assignments $assignment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Assignments $assignment)
    {
        try {
            $this->assignmentService->deleteAssignment($assignment);

            return redirect()->route('assignment.index')
                ->with('success', 'Assignment berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus assignment: ' . $e->getMessage());
        }
    }
}
