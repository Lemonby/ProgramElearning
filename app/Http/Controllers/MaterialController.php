<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
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
        $materials = Material::with('class')->latest()->get();

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $classes = ClassModel::all();

    return view('materials.create',
        compact('classes'));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(StoreMaterialRequest $request)
{
    $validated = $request->validated();

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
        $classes = ClassModel::all();
        return view('materials.edit', compact('material', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $validated = $request->validated();

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
        Storage::disk('public')->delete($material->file_url);
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Materi berhasil dihapus');
    }
}
