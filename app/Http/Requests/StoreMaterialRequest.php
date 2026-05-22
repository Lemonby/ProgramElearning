<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'class_id' => 'required|integer|exists:classes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'file' => 'required|file|mimes:pdf,ppt,pptx,doc,docx,xls,xlsx,zip,rar|max:25600',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'class_id.required' => 'Kelas harus dipilih.',
            'class_id.exists' => 'Kelas yang dipilih tidak valid.',
            
            'title.required' => 'Judul materi harus diisi.',
            'title.string' => 'Judul materi harus berupa teks.',
            'title.max' => 'Judul materi tidak boleh lebih dari 255 karakter.',
            
            'description.string' => 'Deskripsi materi harus berupa teks.',
            'description.max' => 'Deskripsi materi tidak boleh lebih dari 2000 karakter.',
            
            'file.required' => 'File materi harus diupload.',
            'file.file' => 'File materi harus berupa file yang valid.',
            'file.mimes' => 'File materi harus berformat: PDF, PPT, PPTX, DOC, DOCX, XLS, XLSX, ZIP, atau RAR.',
            'file.max' => 'File materi tidak boleh lebih dari 25 MB.',
        ];
    }
}
