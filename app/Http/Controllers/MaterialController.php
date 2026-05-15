<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facedes\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::latest()->get();

        return view('materials.index', compact ('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'file' => 'required|mimes:pdf,ppt,pptx,doc,docx|max:20480'
        ]);

        $filePath = $request->file('file')->store('materials', 'public');

        Material::create([
            'title' => $request->title,
            'description' => $request->description,
            'file' => $filePath
        ]);

        return redirect()->route('materials.index')
        ->with('success', 'Materi Berhasil Ditambahkan');
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
    public function edit(string $id)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required'
        ]);

        if($request->hasFile('file')){
            storage::disk('public')->delete($material->file);

            $filePath = $request->file('file')
            ->store('materials', 'public');

            $material->file = $filePath;
        }

        $material->update([
            'title' => $request->title,
            'description' => $request->description,
            'file' => $material->file
        ]);

        return redirect()->route('materials.index');
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        storage::disk('public')->delete($material->file);
        $material->delete();

        return redirect()->route('materials.index')
        ->with('success', 'Materi Berhasil Dihapus');
        
    }
}
