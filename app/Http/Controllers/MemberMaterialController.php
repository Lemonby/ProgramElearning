<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MemberMaterialController extends Controller
{
    /**
     * Display a listing of materials for the authenticated member.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get materials for the member's class via Class Eloquent Relationship
        $materials = $user->class
            ? $user->class->materials()->latest()->get()
            : collect();

        return view('looksmaterials.index', compact('materials', 'user'));
    }

    /**
     * Display the specified material.
     */
    public function show(Material $material)
    {
        $this->authorize('view', $material);
        $user = Auth::user();

        return view('looksmaterials.show', compact('material', 'user'));
    }

    /**
     * Download the material file.
     */
    public function download(Material $material)
    {
        $this->authorize('download', $material);

        return response()->download(storage_path('app/public/' . $material->file_url));
    }
}
