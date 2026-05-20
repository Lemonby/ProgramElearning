<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userClassId = Auth::user()->class_id;
        $materials = Material::with('class')
                            ->where('class_id', $userClassId)
                            ->latest()
                            ->get();

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userClassId = Auth::user()->class_id;
        // Only show the mentor's own class
        $classes = ClassModel::where('id', $userClassId)->get();

        return view('materials.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialRequest $request)
    {
        $validated = $request->validated();
        $userClassId = Auth::user()->class_id;

        // Ensure mentor can only upload to their own class
        if ((int)$validated['class_id'] !== (int)$userClassId) {
            abort(403, 'Anda hanya dapat mengunggah materi untuk kelas Anda sendiri');
        }

        $path = $request->file('file')
                        ->store('materials', 'public');

        Material::create([
            'class_id' => $validated['class_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_url' => $path,
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil ditambahkan');
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
    public function edit(Material $material)
    {
        $this->authorize('update', $material);

        $userClassId = Auth::user()->class_id;
        // Only show the mentor's own class
        $classes = ClassModel::where('id', $userClassId)->get();
        return view('materials.edit', compact('material', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $this->authorize('update', $material);

        $validated = $request->validated();
        $userClassId = Auth::user()->class_id;

        // Prevent changing class_id
        if ((int)$validated['class_id'] !== (int)$userClassId) {
            abort(403, 'Anda tidak dapat mengubah kelas materi ini');
        }

        if($request->hasFile('file')){
            Storage::disk('public')->delete($material->file_url);

            $filePath = $request->file('file')
            ->store('materials', 'public');

            $validated['file_url'] = $filePath;
        }

        $material->update([
            'class_id' => $validated['class_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_url' => $validated['file_url'] ?? $material->file_url
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil diperbarui');
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);

        Storage::disk('public')->delete($material->file_url);
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil dihapus');
    }
}
