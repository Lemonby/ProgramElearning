<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use App\Models\ClassModel;

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
    $classes = ClassModel::all();

    return view('materials.create',
        compact('classes'));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'class_id' => 'required',
        'title' => 'required',
        'file' => 'required|mimes:pdf,ppt,pptx,doc,docx|max:20480'
    ]);

    $path = $request->file('file')
                    ->store('materials', 'public');

    Material::create([
        'class_id' => $request->class_id,
        'title' => $request->title,
        'description' => $request->description,
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
